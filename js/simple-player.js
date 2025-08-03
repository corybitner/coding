/**
 * Simple Audio Player - Core JavaScript
 * Includes keyboard controls, seeking, volume control, and playlist management
 */

class SimpleAudioPlayer {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error('Simple Audio Player: Container not found');
            return;
        }
        
        this.options = {
            autoplay: false,
            theme: 'light',
            keyboardControls: true,
            volume: 0.8,
            playbackRates: [0.5, 0.75, 1, 1.25, 1.5, 2],
            ...options
        };
        
        this.audio = this.container.querySelector('.sap-audio-element');
        this.playlist = [];
        this.currentTrack = 0;
        this.isPlaying = false;
        this.isDragging = false;
        this.volume = this.options.volume;
        this.isMuted = false;
        this.currentPlaybackRate = 1;
        this.loop = false;
        
        this.init();
    }
    
    init() {
        this.loadPlaylist();
        this.bindEvents();
        this.setupKeyboardControls();
        this.audio.volume = this.volume;
        this.updateVolumeDisplay();
        
        if (this.playlist.length > 0) {
            this.loadTrack(0);
        }
    }
    
    loadPlaylist() {
        const items = this.container.querySelectorAll('.sap-playlist-item');
        this.playlist = Array.from(items).map((item, index) => ({
            index: index,
            url: item.dataset.src,
            title: item.dataset.title || 'Unknown Track',
            artist: item.dataset.artist || 'Unknown Artist',
            duration: item.dataset.duration || '',
            element: item
        }));
    }
    
    bindEvents() {
        // Play/Pause buttons
        const playPauseBtns = this.container.querySelectorAll('.sap-play-pause-btn, .sap-play-pause-main');
        playPauseBtns.forEach(btn => {
            btn.addEventListener('click', () => this.togglePlayPause());
        });
        
        // Previous/Next buttons
        this.container.querySelector('.sap-prev-btn')?.addEventListener('click', () => this.previousTrack());
        this.container.querySelector('.sap-next-btn')?.addEventListener('click', () => this.nextTrack());
        
        // Speed button
        this.container.querySelector('.sap-speed-btn')?.addEventListener('click', () => this.togglePlaybackRate());
        
        // Loop button
        this.container.querySelector('.sap-loop-btn')?.addEventListener('click', () => this.toggleLoop());
        
        // Volume button
        this.container.querySelector('.sap-volume-btn')?.addEventListener('click', () => this.toggleMute());
        
        // Seekbar
        const seekbar = this.container.querySelector('.sap-seekbar');
        if (seekbar) {
            seekbar.addEventListener('click', (e) => this.seek(e));
            seekbar.addEventListener('mousedown', (e) => this.startSeeking(e));
        }
        
        // Volume slider
        const volumeSlider = this.container.querySelector('.sap-volume-slider');
        if (volumeSlider) {
            volumeSlider.addEventListener('click', (e) => this.setVolume(e));
            volumeSlider.addEventListener('mousedown', (e) => this.startVolumeChange(e));
        }
        
        // Playlist items
        this.container.querySelectorAll('.sap-playlist-item').forEach((item, index) => {
            item.addEventListener('click', () => this.selectTrack(index));
        });
        
        // Audio events
        this.audio.addEventListener('loadedmetadata', () => this.onLoadedMetadata());
        this.audio.addEventListener('timeupdate', () => this.onTimeUpdate());
        this.audio.addEventListener('ended', () => this.onTrackEnded());
        this.audio.addEventListener('canplay', () => this.onCanPlay());
        this.audio.addEventListener('waiting', () => this.onWaiting());
        this.audio.addEventListener('progress', () => this.updateBuffer());
        
        // Mouse events for dragging
        document.addEventListener('mousemove', (e) => this.onMouseMove(e));
        document.addEventListener('mouseup', () => this.stopDragging());
    }
    
    setupKeyboardControls() {
        if (!this.options.keyboardControls) return;
        
        document.addEventListener('keydown', (e) => {
            // Only handle if the player container is in focus or no input is focused
            if (document.activeElement?.tagName === 'INPUT' || 
                document.activeElement?.tagName === 'TEXTAREA') {
                return;
            }
            
            switch (e.code) {
                case 'Space':
                    e.preventDefault();
                    this.togglePlayPause();
                    break;
                case 'KeyP':
                    e.preventDefault();
                    this.previousTrack();
                    break;
                case 'KeyN':
                    e.preventDefault();
                    this.nextTrack();
                    break;
                case 'KeyM':
                    e.preventDefault();
                    this.toggleMute();
                    break;
                case 'KeyL':
                    e.preventDefault();
                    this.toggleLoop();
                    break;
                case 'KeyS':
                    e.preventDefault();
                    this.togglePlaybackRate();
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    this.seekBackward(10);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.seekForward(10);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.changeVolume(0.1);
                    break;
                case 'ArrowDown':
                    e.preventDefault();
                    this.changeVolume(-0.1);
                    break;
            }
        });
    }
    
    loadTrack(index) {
        if (index < 0 || index >= this.playlist.length) return;
        
        this.currentTrack = index;
        const track = this.playlist[index];
        
        this.audio.src = track.url;
        this.updateTrackInfo(track);
        this.updatePlaylistHighlight();
        
        // Try to get album art from ID3 tags or use default
        this.updateAlbumArt(track);
    }
    
    updateTrackInfo(track) {
        const titleEl = this.container.querySelector('.sap-track-title');
        const artistEl = this.container.querySelector('.sap-track-artist');
        
        if (titleEl) titleEl.textContent = track.title;
        if (artistEl) artistEl.textContent = track.artist;
    }
    
    updateAlbumArt(track) {
        const artImg = this.container.querySelector('.sap-album-art');
        if (!artImg) return;
        
        // Set a default gradient background
        const artwork = this.container.querySelector('.sap-artwork');
        artwork.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        
        // Try to extract album art from audio file
        if (window.jsmediatags) {
            jsmediatags.read(track.url, {
                onSuccess: (tag) => {
                    const image = tag.tags.picture;
                    if (image) {
                        const base64String = image.data.reduce((data, byte) => {
                            return data + String.fromCharCode(byte);
                        }, '');
                        const base64 = btoa(base64String);
                        const dataUrl = `data:${image.format};base64,${base64}`;
                        artImg.src = dataUrl;
                        artImg.style.display = 'block';
                    } else {
                        artImg.style.display = 'none';
                    }
                },
                onError: () => {
                    artImg.style.display = 'none';
                }
            });
        } else {
            artImg.style.display = 'none';
        }
    }
    
    updatePlaylistHighlight() {
        this.container.querySelectorAll('.sap-playlist-item').forEach((item, index) => {
            item.classList.toggle('active', index === this.currentTrack);
            item.classList.toggle('playing', index === this.currentTrack && this.isPlaying);
        });
    }
    
    togglePlayPause() {
        if (this.isPlaying) {
            this.pause();
        } else {
            this.play();
        }
    }
    
    play() {
        const playPromise = this.audio.play();
        if (playPromise !== undefined) {
            playPromise.then(() => {
                this.isPlaying = true;
                this.updatePlayPauseButtons();
                this.updatePlaylistHighlight();
            }).catch((error) => {
                console.error('Playback failed:', error);
            });
        }
    }
    
    pause() {
        this.audio.pause();
        this.isPlaying = false;
        this.updatePlayPauseButtons();
        this.updatePlaylistHighlight();
    }
    
    previousTrack() {
        let newIndex = this.currentTrack - 1;
        if (newIndex < 0) {
            newIndex = this.playlist.length - 1;
        }
        this.selectTrack(newIndex);
    }
    
    nextTrack() {
        let newIndex = this.currentTrack + 1;
        if (newIndex >= this.playlist.length) {
            newIndex = 0;
        }
        this.selectTrack(newIndex);
    }
    
    selectTrack(index) {
        const wasPlaying = this.isPlaying;
        this.pause();
        this.loadTrack(index);
        if (wasPlaying) {
            this.play();
        }
    }
    
    seek(event) {
        if (this.isDragging) return;
        
        const seekbar = event.currentTarget;
        const rect = seekbar.getBoundingClientRect();
        const percent = (event.clientX - rect.left) / rect.width;
        const time = percent * this.audio.duration;
        
        if (!isNaN(time)) {
            this.audio.currentTime = time;
        }
    }
    
    startSeeking(event) {
        this.isDragging = true;
        this.seek(event);
    }
    
    seekForward(seconds) {
        this.audio.currentTime = Math.min(this.audio.currentTime + seconds, this.audio.duration);
    }
    
    seekBackward(seconds) {
        this.audio.currentTime = Math.max(this.audio.currentTime - seconds, 0);
    }
    
    setVolume(event) {
        const slider = event.currentTarget;
        const rect = slider.getBoundingClientRect();
        const percent = (event.clientX - rect.left) / rect.width;
        
        this.volume = Math.max(0, Math.min(1, percent));
        this.audio.volume = this.volume;
        this.isMuted = false;
        this.updateVolumeDisplay();
    }
    
    startVolumeChange(event) {
        this.isDraggingVolume = true;
        this.setVolume(event);
    }
    
    changeVolume(delta) {
        this.volume = Math.max(0, Math.min(1, this.volume + delta));
        this.audio.volume = this.volume;
        this.isMuted = false;
        this.updateVolumeDisplay();
    }
    
    toggleMute() {
        this.isMuted = !this.isMuted;
        this.audio.volume = this.isMuted ? 0 : this.volume;
        this.updateVolumeDisplay();
    }
    
    togglePlaybackRate() {
        const currentIndex = this.options.playbackRates.indexOf(this.currentPlaybackRate);
        const nextIndex = (currentIndex + 1) % this.options.playbackRates.length;
        this.currentPlaybackRate = this.options.playbackRates[nextIndex];
        this.audio.playbackRate = this.currentPlaybackRate;
        
        const speedBtn = this.container.querySelector('.sap-speed-btn');
        if (speedBtn) {
            speedBtn.textContent = `${this.currentPlaybackRate}x`;
        }
    }
    
    toggleLoop() {
        this.loop = !this.loop;
        const loopBtn = this.container.querySelector('.sap-loop-btn');
        if (loopBtn) {
            loopBtn.classList.toggle('active', this.loop);
        }
    }
    
    onMouseMove(event) {
        if (this.isDragging) {
            this.seek(event);
        }
        if (this.isDraggingVolume) {
            this.setVolume(event);
        }
    }
    
    stopDragging() {
        this.isDragging = false;
        this.isDraggingVolume = false;
    }
    
    onLoadedMetadata() {
        this.updateTimeDisplay();
        this.updateProgress();
    }
    
    onTimeUpdate() {
        if (!this.isDragging) {
            this.updateProgress();
        }
        this.updateTimeDisplay();
    }
    
    onTrackEnded() {
        if (this.loop) {
            this.audio.currentTime = 0;
            this.play();
        } else {
            this.nextTrack();
        }
    }
    
    onCanPlay() {
        this.container.classList.remove('sap-loading');
    }
    
    onWaiting() {
        this.container.classList.add('sap-loading');
    }
    
    updatePlayPauseButtons() {
        const playPauseBtns = this.container.querySelectorAll('.sap-play-pause-btn .sap-icon, .sap-play-pause-main .sap-icon');
        playPauseBtns.forEach(icon => {
            icon.className = this.isPlaying ? 'sap-icon sap-icon-pause' : 'sap-icon sap-icon-play';
        });
    }
    
    updateProgress() {
        if (!this.audio.duration) return;
        
        const percent = (this.audio.currentTime / this.audio.duration) * 100;
        const progressBar = this.container.querySelector('.sap-seekbar-progress');
        const handle = this.container.querySelector('.sap-seekbar-handle');
        
        if (progressBar) {
            progressBar.style.width = `${percent}%`;
        }
        if (handle) {
            handle.style.left = `${percent}%`;
        }
    }
    
    updateBuffer() {
        if (!this.audio.buffered.length || !this.audio.duration) return;
        
        const bufferedEnd = this.audio.buffered.end(this.audio.buffered.length - 1);
        const percent = (bufferedEnd / this.audio.duration) * 100;
        const bufferBar = this.container.querySelector('.sap-seekbar-buffer');
        
        if (bufferBar) {
            bufferBar.style.width = `${percent}%`;
        }
    }
    
    updateTimeDisplay() {
        const currentTimeEl = this.container.querySelector('.sap-time-current');
        const totalTimeEl = this.container.querySelector('.sap-time-total');
        
        if (currentTimeEl) {
            currentTimeEl.textContent = this.formatTime(this.audio.currentTime || 0);
        }
        if (totalTimeEl) {
            totalTimeEl.textContent = this.formatTime(this.audio.duration || 0);
        }
    }
    
    updateVolumeDisplay() {
        const volumeLevel = this.container.querySelector('.sap-volume-level');
        const volumeHandle = this.container.querySelector('.sap-volume-handle');
        const volumeBtn = this.container.querySelector('.sap-volume-btn .sap-icon');
        
        const displayVolume = this.isMuted ? 0 : this.volume;
        const percent = displayVolume * 100;
        
        if (volumeLevel) {
            volumeLevel.style.width = `${percent}%`;
        }
        if (volumeHandle) {
            volumeHandle.style.left = `${percent}%`;
        }
        if (volumeBtn) {
            volumeBtn.className = this.isMuted || this.volume === 0 ? 
                'sap-icon sap-icon-volume-mute' : 'sap-icon sap-icon-volume';
        }
    }
    
    formatTime(seconds) {
        if (!seconds || isNaN(seconds)) return '0:00';
        
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
    
    // Public API methods
    getCurrentTrack() {
        return this.playlist[this.currentTrack];
    }
    
    getPlaylist() {
        return this.playlist;
    }
    
    isCurrentlyPlaying() {
        return this.isPlaying;
    }
    
    setTheme(theme) {
        this.container.classList.remove('sap-light', 'sap-dark');
        this.container.classList.add(`sap-${theme}`);
    }
}

// Make it available globally
window.SimpleAudioPlayer = SimpleAudioPlayer;