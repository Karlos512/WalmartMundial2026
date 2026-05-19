/*
  © 2025 Techxedo. All rights reserved.
  This JavaScript file is part of a copyrighted HTML5 game.
*/

const audioManager = {
    sounds: {
        swap: new Audio('./juego/assets/audio/swap.mp3'),
        match: new Audio('./juego/assets/audio/match.mp3'),
        invalid: new Audio('./juego/assets/audio/invalid.mp3'),
        gameOver: new Audio('./juego/assets/audio/game-over.mp3'),
        hint: new Audio('./juego/assets/audio/hint.mp3')
    },
    music: null,
    isSoundEnabled: true,
    isMusicEnabled: true,
    initialized: false,
    
    init() {
        if (this.initialized) return;
        
        // console.log('Initializing audio manager...');
        
        // Load saved preferences
        this.loadPreferences();
        
        // Initialize music
        this.initMusic();
        
        // Wait for DOM to be ready before setting up buttons
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.setupButtons();
            });
        } else {
            // DOM already ready, set up buttons now
            this.setupButtons();
        }
        
        this.initialized = true;
        
        // console.log('Audio manager initialized with settings:', {
        //     musicEnabled: this.isMusicEnabled,
        //     soundEnabled: this.isSoundEnabled
        // });
    },
    
    loadPreferences() {
        // Load settings from localStorage if available
        const savedSoundSetting = localStorage.getItem('soundEnabled');
        const savedMusicSetting = localStorage.getItem('musicEnabled');
        
        if (savedSoundSetting !== null) {
            this.isSoundEnabled = savedSoundSetting === 'true';
        }
        
        if (savedMusicSetting !== null) {
            this.isMusicEnabled = savedMusicSetting === 'true';
        }
    },
    
    initMusic() {
        try {
            this.music = new Audio('./juego/assets/audio/background-music.mp3');
            this.music.loop = true;
            this.music.volume = 0.3; // Lower volume
            
            // Add error handling for music
            this.music.addEventListener('error', (e) => {
                console.error('Error loading music:', e);
            });
        } catch (error) {
            console.error('Failed to initialize music:', error);
        }
    },
    
    setupButtons() {
        // console.log('Setting up audio control buttons...');
        
        try {
            // Get button references
            const musicBtn = document.getElementById('musicToggleBtn');
            const soundBtn = document.getElementById('soundToggleBtn');
            
            // Check for duplicate icons and fix them
            this.fixDuplicateIcons(musicBtn);
            this.fixDuplicateIcons(soundBtn);
            
            // Safely set up music button
            if (musicBtn && !musicBtn.hasAttribute('data-initialized')) {
                // Add event listener
                musicBtn.onclick = (event) => {
                    event.preventDefault();
                    this.toggleMusic();
                    return false;
                };
                
                // Mark as initialized to prevent duplicate listeners
                musicBtn.setAttribute('data-initialized', 'true');
                // console.log('Added event listener to music button');
            }
            
            // Safely set up sound button
            if (soundBtn && !soundBtn.hasAttribute('data-initialized')) {
                // Add event listener
                soundBtn.onclick = (event) => {
                    event.preventDefault();
                    this.toggleSound();
                    return false;
                };
                
                // Mark as initialized to prevent duplicate listeners
                soundBtn.setAttribute('data-initialized', 'true');
                // console.log('Added event listener to sound button');
            }
            
            // Update button states to match current settings
            this.updateButtonStates();
        } catch (error) {
            console.error('Error setting up audio buttons:', error);
        }
    },
    
    fixDuplicateIcons(button) {
        if (!button) return;
        
        // Check for duplicate icon elements
        const icons = button.querySelectorAll('i');
        if (icons.length > 1) {
            console.log(`Found ${icons.length} icons in button, fixing...`);
            
            // Keep only the first icon
            for (let i = 1; i < icons.length; i++) {
                icons[i].remove();
            }
        }
        
        // Check for duplicate status elements
        const statusElements = button.querySelectorAll('.audio-status');
        if (statusElements.length > 1) {
            console.log(`Found ${statusElements.length} status elements in button, fixing...`);
            
            // Keep only the first status element
            for (let i = 1; i < statusElements.length; i++) {
                statusElements[i].remove();
            }
        }
    },
    
    updateButtonStates() {
        try {
            const musicBtn = document.getElementById('musicToggleBtn');
            const soundBtn = document.getElementById('soundToggleBtn');
            
            if (musicBtn) {
                // Update music button state
                musicBtn.classList.toggle('disabled', !this.isMusicEnabled);
                const musicStatus = musicBtn.querySelector('.audio-status');
                if (musicStatus) {
                    musicStatus.textContent = this.isMusicEnabled ? 'ON' : 'OFF';
                }
                
                // Update icon if needed
                const musicIcon = musicBtn.querySelector('i');
                if (musicIcon) {
                    musicIcon.textContent = this.isMusicEnabled ? '🎵' : '🚫';
                }
            }
            
            if (soundBtn) {
                // Update sound button state
                soundBtn.classList.toggle('disabled', !this.isSoundEnabled);
                const soundStatus = soundBtn.querySelector('.audio-status');
                if (soundStatus) {
                    soundStatus.textContent = this.isSoundEnabled ? 'ON' : 'OFF';
                }
                
                // Update icon if needed
                const soundIcon = soundBtn.querySelector('i');
                if (soundIcon) {
                    soundIcon.textContent = this.isSoundEnabled ? '🔊' : '🔇';
                }
            }
        } catch (error) {
            console.error('Error updating button states:', error);
        }
    },
    
    playSound(sound) {
        if (!this.isSoundEnabled || !this.sounds[sound]) return;
        
        try {
            // Create a fresh audio instance for better compatibility
            const soundEffect = new Audio(this.sounds[sound].src);
            soundEffect.volume = 0.5; // Moderate volume for sound effects
            
            soundEffect.play().catch(error => {
                console.warn(`Could not play sound "${sound}":`, error);
            });
        } catch (error) {
            console.error(`Error playing sound "${sound}":`, error);
        }
    },
    
    playMusic() {
        if (!this.isMusicEnabled || !this.music) return;
        
        try {
            // console.log('Attempting to play background music...');
            this.music.currentTime = 0;
            
            const playPromise = this.music.play();
            if (playPromise) {
                playPromise.catch(error => {
                    console.warn('Could not autoplay music:', error);
                    
                    // Set up one-time click handler to start music
                    const handleClick = () => {
                        this.music.play().catch(e => console.warn('Still could not play music:', e));
                        document.removeEventListener('click', handleClick);
                    };
                    
                    document.addEventListener('click', handleClick, { once: true });
                });
            }
        } catch (error) {
            console.error('Error playing music:', error);
        }
    },
    
    pauseMusic() {
        if (!this.music) return;
        
        try {
            this.music.pause();
        } catch (error) {
            console.error('Error pausing music:', error);
        }
    },
    
    resumeMusic() {
        if (!this.music || !this.isMusicEnabled) return;
        
        try {
            const playPromise = this.music.play();
            if (playPromise) {
                playPromise.catch(error => {
                    console.warn('Could not resume music:', error);
                });
            }
        } catch (error) {
            console.error('Error resuming music:', error);
        }
    },
    
    toggleSound() {
        this.isSoundEnabled = !this.isSoundEnabled;
        localStorage.setItem('soundEnabled', this.isSoundEnabled);
        
        console.log('Sound toggled:', this.isSoundEnabled ? 'ON' : 'OFF');
        
        // Update button states
        this.updateButtonStates();
        
        // Play a test sound if enabled
        if (this.isSoundEnabled) {
            this.playSound('swap');
        }
    },
    
    toggleMusic() {
        this.isMusicEnabled = !this.isMusicEnabled;
        localStorage.setItem('musicEnabled', this.isMusicEnabled);
        
        // console.log('Music toggled:', this.isMusicEnabled ? 'ON' : 'OFF');
        
        if (this.isMusicEnabled) {
            this.playMusic();
        } else {
            this.pauseMusic();
        }
        
        // Update button states
        this.updateButtonStates();
    }
};

// Initialize audio manager
audioManager.init();

// Simpler way to handle dynamically added buttons
// Check periodically for buttons without listeners
setInterval(() => {
    const musicBtn = document.getElementById('musicToggleBtn');
    const soundBtn = document.getElementById('soundToggleBtn');
    
    // Check if the buttons exist but don't have event listeners
    if (musicBtn && !musicBtn.hasAttribute('data-has-listener')) {
        musicBtn.onclick = (event) => {
            event.preventDefault();
            audioManager.toggleMusic();
            return false;
        };
        musicBtn.setAttribute('data-has-listener', 'true');
    }
    
    if (soundBtn && !soundBtn.hasAttribute('data-has-listener')) {
        soundBtn.onclick = (event) => {
            event.preventDefault();
            audioManager.toggleSound();
            return false;
        };
        soundBtn.setAttribute('data-has-listener', 'true');
    }
    
    // Update button states to ensure they reflect current settings
    if ((musicBtn && musicBtn.hasAttribute('data-has-listener')) || 
        (soundBtn && soundBtn.hasAttribute('data-has-listener'))) {
        audioManager.updateButtonStates();
    }
}, 1000); // Check every second

export default audioManager; 