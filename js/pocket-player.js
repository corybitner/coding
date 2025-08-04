/**
 * Pocket Audio Player - Core JavaScript
 * Includes keyboard controls, seeking, volume control, and playlist management
 */

class PocketAudioPlayer {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error('Pocket Audio Player: Container not found');
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
        this.isActive = false; // Track which player is active for keyboard controls
        this.loadTimeout = null; // Store timeout for cleanup

        // Register this player globally for multi-player management
        if (!window.pocketAudioPlayers) {
            window.pocketAudioPlayers = [];
        }
        window.pocketAudioPlayers.push(this);

                this.init();
    }

    init() {
        this.loadPlaylist();
        this.bindEvents();
        this.setupKeyboardControls();
        this.audio.volume = this.volume;
        this.updateVolumeDisplay();

        // Set as active if it's the first player or no active player exists
        const hasActivePlayer = window.pocketAudioPlayers?.some(player => player.isActive);
        if (!hasActivePlayer) {
            this.setActivePlayer();
        }

        if (this.playlist.length > 0) {
            this.selectTrack(0);
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

        // Make this player active when clicked anywhere on it
        this.container.addEventListener('click', () => this.setActivePlayer());
        
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

            // Track hover state
            this.isHovered = false;
            
            this.container.addEventListener('mouseenter', () => {
                this.isHovered = true;
            });
            
            this.container.addEventListener('mouseleave', () => {
                this.isHovered = false;
            });

            document.addEventListener('keydown', (e) => {
                // Only handle if this player is hovered and no input is focused
                if (!this.isHovered || 
                    document.activeElement?.tagName === 'INPUT' ||
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
                       case 'Enter':
                       case 'NumpadEnter':
                           e.preventDefault();
                           this.rewindToStart();
                           break;
            }
        });
    }
    
            
    
    updateTrackInfo(track) {
        const titleEl = this.container.querySelector('.sap-track-title');
        const artistEl = this.container.querySelector('.sap-track-artist');
        
        if (titleEl) titleEl.textContent = track.title;
        if (artistEl) artistEl.textContent = track.artist;
    }
    
    updateAlbumArt(track) {
        const artImg = this.container.querySelector('.sap-album-art');
        const artwork = this.container.querySelector('.sap-artwork');
        if (!artImg) return;

        // Check if track has a thumbnail from M3U
        if (track.thumbnail) {
            artImg.src = track.thumbnail;
            artImg.style.display = 'block';
            artwork.style.background = 'none';
            return;
        }

        // Use default audio poster
        try {
            const defaultPoster = (typeof pap_ajax !== 'undefined' && pap_ajax.plugin_url) 
                ? pap_ajax.plugin_url + 'assets/audio-poster.jpg'
                : '/wp-content/plugins/pocket-audio-player/assets/audio-poster.jpg';
            
            artImg.src = defaultPoster;
            artImg.style.display = 'block';
            artwork.style.background = 'none';
            
            // Handle image load error
            artImg.onerror = () => {
                artImg.style.display = 'none';
                artwork.style.background = 'linear-gradient(135deg, #5382F6 0%, #46BA74 100%)';
            };
        } catch (error) {
            // Fallback to gradient if there's any error
            artImg.style.display = 'none';
            artwork.style.background = 'linear-gradient(135deg, #5382F6 0%, #46BA74 100%)';
        }

        // Try to extract album art from audio file (will override default if found)
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
                        artwork.style.background = 'none';
                    }
                    // If no ID3 art found, keep the default poster
                },
                onError: () => {
                    // Keep the default poster on error
                }
            });
        }
        // If no jsmediatags library, keep the default poster
    }
    
            updatePlaylistHighlight() {
            this.container.querySelectorAll('.sap-playlist-item').forEach((item, index) => {
                item.classList.toggle('active', index === this.currentTrack);
                item.classList.toggle('playing', index === this.currentTrack && this.isPlaying);
            });
            
            // Scroll current track into view
            this.scrollCurrentTrackIntoView();
        }

        scrollCurrentTrackIntoView() {
            const currentItem = this.container.querySelector('.sap-playlist-item.active');
            const playlistContainer = this.container.querySelector('.sap-playlist-items');
            
            if (currentItem && playlistContainer) {
                const containerRect = playlistContainer.getBoundingClientRect();
                const itemRect = currentItem.getBoundingClientRect();
                
                // Check if item is outside visible area
                const isAbove = itemRect.top < containerRect.top;
                const isBelow = itemRect.bottom > containerRect.bottom;
                
                if (isAbove || isBelow) {
                    currentItem.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                        inline: 'nearest'
                    });
                }
            }
        }
    
    togglePlayPause() {
        if (this.isPlaying) {
            this.pause();
        } else {
            this.play();
        }
    }
    
            play() {
            // Auto-pause other players when this one starts
            this.pauseAllOtherPlayers();
            this.setActivePlayer();
            
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
            if (index < 0 || index >= this.playlist.length) return;
            
            const wasPlaying = this.isPlaying;
            
            // Clear any pending operations
            if (this.loadTimeout) {
                clearTimeout(this.loadTimeout);
                this.loadTimeout = null;
            }
            
            // Immediately pause current track
            this.pause();
            this.audio.currentTime = 0;
            
            // Set new track immediately for UI feedback
            this.currentTrack = index;
            const track = this.playlist[index];
            this.updateTrackInfo(track);
            this.updatePlaylistHighlight();
            
            // Load and potentially play the new track
            this.loadNewTrack(track, wasPlaying);
        }

        loadNewTrack(track, shouldAutoPlay) {
            // Set the new audio source
            this.audio.src = track.url;
            this.updateAlbumArt(track);
            
            // Use a more aggressive approach for auto-play
            if (shouldAutoPlay) {
                // Try multiple strategies to ensure playback
                this.attemptAutoPlay();
            }
        }

        attemptAutoPlay() {
            // Strategy 1: Try to play immediately
            const playImmediately = () => {
                const playPromise = this.audio.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        this.isPlaying = true;
                        this.updatePlayPauseButtons();
                        this.updatePlaylistHighlight();
                    }).catch(() => {
                        // Strategy 2: Wait for loadeddata and try again
                        this.waitAndRetryPlay();
                    });
                } else {
                    // Fallback for older browsers
                    this.waitAndRetryPlay();
                }
            };

            // Try immediately first
            playImmediately();
        }

        waitAndRetryPlay() {
            const retryPlay = () => {
                this.audio.removeEventListener('loadeddata', retryPlay);
                this.audio.removeEventListener('canplay', retryPlay);
                
                // Clear any existing timeout
                if (this.loadTimeout) {
                    clearTimeout(this.loadTimeout);
                }
                
                // Try playing with a small delay
                this.loadTimeout = setTimeout(() => {
                    const playPromise = this.audio.play();
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            this.isPlaying = true;
                            this.updatePlayPauseButtons();
                            this.updatePlaylistHighlight();
                        }).catch((error) => {
                            console.warn('Auto-play failed:', error);
                            // Don't update playing state if it failed
                        });
                    }
                }, 100);
            };

            // Listen for multiple audio ready events
            this.audio.addEventListener('loadeddata', retryPlay);
            this.audio.addEventListener('canplay', retryPlay);
            
            // Force load
            this.audio.load();
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

                   rewindToStart() {
            this.audio.currentTime = 0;
        }

        // Multi-player management methods
        setActivePlayer() {
            // Deactivate all other players
            if (window.pocketAudioPlayers) {
                window.pocketAudioPlayers.forEach(player => {
                    player.isActive = false;
                    player.container.classList.remove('sap-active-player');
                });
            }
            
            // Activate this player
            this.isActive = true;
            this.container.classList.add('sap-active-player');
        }

        pauseAllOtherPlayers() {
            if (window.pocketAudioPlayers) {
                window.pocketAudioPlayers.forEach(player => {
                    if (player !== this && player.isPlaying) {
                        player.pause();
                    }
                });
            }
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
               this.nextTrack();
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
window.PocketAudioPlayer = PocketAudioPlayer;