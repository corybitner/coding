# Pocket Audio Player

A lightweight WordPress audio player plugin with M3U playlist support, keyboard controls, and beautiful modern design. Built from the ground up to be fast, simple, and efficient.

## ✨ Features

- **🎵 M3U Playlist Support** - Upload and parse M3U/M3U8 files
- **⌨️ Keyboard Controls** - Full keyboard navigation
- **🎨 Modern Theme** - Beautiful album art-focused design  
- **📱 Responsive Design** - Works on desktop, tablet, and mobile
- **🔄 Playback Controls** - Play, pause, next, previous, speed control
- **🔊 Volume Control** - Click or drag volume slider
- **📖 Simple Usage** - Just use a shortcode
- **🚀 Lightweight** - Only ~1000 lines vs 5,680+ in original

## 📦 Installation

1. **Upload the plugin files** to `/wp-content/plugins/pocket-audio-player/`
2. **Activate the plugin** through the 'Plugins' menu in WordPress
3. **Upload your M3U files** to your WordPress media library
4. **Use the shortcode** in posts, pages, or widgets

## 🎯 Usage

### Basic Usage

Upload an M3U file to your media library, then use:

```php
[pocket_audio_playlist file="my-playlist.m3u"]
```

### Advanced Usage

```php
[pocket_audio_playlist file="my-playlist.m3u" theme="dark" width="600px" autoplay="true"]
```

### Shortcode Parameters

| Parameter | Default | Description |
|-----------|---------|-------------|
| `file` | *required* | Path to M3U file (relative to uploads folder or full URL) |
| `theme` | `light` | Theme: `light` or `dark` |
| `width` | `100%` | Player width (CSS units) |
| `height` | `auto` | Player height (CSS units) |
| `autoplay` | `false` | Auto-start playback |

## 🎵 M3U Format Support

The player supports standard M3U and M3U8 playlists:

```m3u
#EXTM3U
#EXTINF:180,Artist Name - Song Title
https://example.com/song1.mp3
#EXTINF:210,Another Artist - Another Song
https://example.com/song2.mp3
```

### Supported Audio Formats
- MP3, M4A, OGG, WAV, FLAC
- Streaming URLs
- Local files

## ⌨️ Keyboard Controls

| Key | Action |
|-----|--------|
| **Space** | Play/Pause |
| **P** | Previous track |
| **N** | Next track |
| **M** | Mute/Unmute |
| **Enter** | Rewind to start of current track |
| **S** | Cycle playback speed |
| **←** | Seek backward 10s |
| **→** | Seek forward 10s |
| **↑** | Volume up |
| **↓** | Volume down |

## 🎨 Themes

### Light Theme (Default)
Clean, bright design perfect for most websites.

### Dark Theme  
Elegant dark design for dark websites or user preference.

```php
[pocket_audio_playlist file="playlist.m3u" theme="dark"]
```

## 📁 File Structure

```
pocket-audio-player/
├── pocket-audio-player.php    # Main plugin file
├── css/
│   └── player-styles.css      # Modern theme styles
├── js/
│   └── pocket-player.js       # Core player functionality
└── README.md                  # This file
```

## 🔧 Developer API

### JavaScript API

Access the player instance:

```javascript
// Get player instance
const player = window.PocketAudioPlayer;

// Public methods
player.getCurrentTrack();     // Get current track info
player.getPlaylist();         // Get full playlist
player.isCurrentlyPlaying();  // Check if playing
player.setTheme('dark');      // Change theme
```

### PHP Hooks

```php
// Allow additional MIME types
add_filter('upload_mimes', function($mimes) {
    $mimes['m3u'] = 'audio/x-mpegurl';
    return $mimes;
});
```

## 🆚 Comparison with Heavy Players

| Feature | Heavy Players | Pocket Audio Player |
|---------|----------|-------------------|
| **File Size** | 5,680+ lines | ~1,000 lines |
| **Files** | 300+ files | 4 files |
| **Admin Interface** | ✅ Complex | ❌ None needed |
| **Statistics** | ✅ Full analytics | ❌ Removed |
| **Advertisements** | ✅ Ad management | ❌ Removed |
| **Multiple Skins** | ✅ 15+ themes | ✅ 1 (Modern) |
| **M3U Support** | ❌ Limited | ✅ Full support |
| **Keyboard Controls** | ✅ Yes | ✅ Yes |
| **Performance** | ⚠️ Heavy | ✅ Lightweight |

## 🐛 Troubleshooting

### M3U File Not Loading
- Ensure the file path is correct
- Check file permissions
- Verify M3U format is valid

### Audio Not Playing
- Check browser console for errors
- Ensure audio files are accessible
- Verify CORS settings for external URLs

### Keyboard Controls Not Working
- Ensure no input fields are focused
- Check browser console for JavaScript errors

## 📝 Example M3U Files

### Simple Playlist
```m3u
#EXTM3U
#EXTINF:180,The Beatles - Hey Jude
/wp-content/uploads/music/hey-jude.mp3
#EXTINF:210,Queen - Bohemian Rhapsody  
https://example.com/bohemian-rhapsody.mp3
```

### Streaming Radio
```m3u
#EXTM3U
#EXTINF:-1,Jazz Radio
http://stream.jazz-radio.com:8000/jazz
#EXTINF:-1,Classical FM
http://stream.classical.fm:8000/classical
```

## 🔄 Migration from Other Players

1. **Export your playlists** as M3U files
2. **Deactivate** your current audio player
3. **Install** Pocket Audio Player
4. **Upload M3U files** to media library
5. **Use shortcode** `[pocket_audio_playlist]`

## 📄 License

This plugin is released under the GPL v2 or later license.

## 🤝 Contributing

Feel free to submit issues and pull requests on GitHub.

## ✨ Credits

A completely independent WordPress audio player built to focus on core functionality with M3U playlist support and modern design.