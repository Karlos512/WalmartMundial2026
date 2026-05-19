# POP CANDY - Game Customization Guide

## Table of Contents
- [Introduction](#introduction)
- [Game Overview](#game-overview)
- [File Structure](#file-structure)
- [Customization Options](#customization-options)
- [Visual Elements](#visual-elements)
- [Gameplay Parameters](#gameplay-parameters)
- [Audio Settings](#audio-settings)
- [Candy Types](#candy-types)
- [Animations](#animations)
- [Advanced Customizations](#advanced-customizations)
- [Adding New Features](#adding-new-features)
- [Scoring System](#scoring-system)
- [Level System](#level-system)
- [Special Candies](#special-candies)
- [Mobile Optimization](#mobile-optimization)
- [Browser Compatibility](#browser-compatibility)
- [Performance Optimization](#performance-optimization)
- [Troubleshooting](#troubleshooting)


# Introduction
Welcome to the POP CANDY Game Customization Guide. This document provides comprehensive instructions for customizing and extending the POP CANDY game. Whether you want to make simple visual adjustments or add complex gameplay mechanics, this guide will help you navigate the codebase and implement your changes effectively.

# Game Overview
POP CANDY is a match-three puzzle game inspired by popular titles like Candy Crush. Players match three or more identical candies in a row or column to score points and extend their playtime. The game features:
A colorful candy-themed interface
Drag-and-drop candy matching
Timer-based gameplay
Score tracking with local high score retention
Sound effects and background music
Hint system for suggesting moves
Responsive design for various devices

# File Structure

```
/
├── index.html            # Main HTML file
├── assets/               # Game assets directory
│   ├── audio/            # Audio files
│   │   ├── background-music.mp3
│   │   ├── match.mp3
│   │   ├── swap.mp3
│   │   ├── invalid.mp3
│   │   ├── gameOver.mp3
│   │   └── hint.mp3
│   ├── star.png          # Candy images
│   ├── heart.png
│   ├── circle.png
│   ├── cube.png
│   ├── diamond.png
│   ├── bubble.png
│   ├── aqua.png
│   ├── rainbow.png
│   ├── candy.png
│   └── background.png    # Game background
├── styles.css            # Main CSS file
├── game.js               # Main game logic
└── audio.js              # Audio management
```

# Customization Options

## Visual Elements

### Game Background

To change the game background:

1. Replace `assets/background.png` with your own image
2. Adjust the background styling in `styles.css`:

```css
body {
    background-image: url('assets/background.png');
    background-size: cover;
    background-position: center;
    /* Adjust these properties as needed */
}
```

### Color Scheme

The color scheme is defined using CSS variables at the top of `styles.css`:

```css
:root {
    --primary-color: #ff61d8;
    --secondary-color: #6a5af9;
    --background-blue: #3498db;
    --light-blue: #5dade2;
    --accent-green: #2ecc71;
    --accent-yellow: #f1c40f;
    --text-color: #ffffff;
    --border-color: #ffffff;
}
```

Modify these values to create a custom color scheme for your game.

### Fonts

To change the game fonts:

1. Import new fonts in `styles.css`:

```css
@import url('https://fonts.googleapis.com/css2?family=Your+Font+Name&display=swap');
```

2. Update the font-family properties:

```css
body {
    font-family: 'Your Font Name', sans-serif;
}

.game-title {
    font-family: 'Your Display Font', cursive;
}
```

### Welcome Screen

The welcome screen can be customized in the HTML and CSS:

```html
<div id="welcomeScreen" class="welcome-screen">
    <h1 class="game-title">
        <span>P</span>
        <span>O</span>
        <span>P</span>
        <!-- Add or remove letters as needed -->
    </h1>
    <button id="startBtn" class="play-button">PLAY</button>
    <!-- Add additional elements here -->
</div>
```

### Game Over Screen

Customize the game over popup in the HTML and with the `addDecorativeCandies()` method in `game.js`:

```javascript
addDecorativeCandies() {
    // Change the number of candies
    for (let i = 0; i < 12; i++) {
        // Customize positions, animations, etc.
    }
}
```

## Gameplay Parameters

### Board Size

To change the game board size, modify the `boardSize` property in the CandyGame constructor:

```javascript
constructor() {
    this.boardSize = 8; // Change to any value (6, 7, 8, 9, 10)
    // Rest of constructor
}
```

Note: Adjusting the board size requires CSS modifications to ensure candies display correctly:

```css
.board {
    /* For an 8×8 board */
    grid-template-columns: repeat(8, 1fr);
    grid-template-rows: repeat(8, 1fr);
}
```

### Timer Settings

Customize timer-related parameters in the CandyGame constructor:

```javascript
constructor() {
    // Timer settings
    this.maxTime = 60; // Starting time in seconds
    this.timeDecreaseRate = 0.4; // Time decrease per second
    this.timeIncreasePerMatch = 2; // Time added per matched candy
    // Rest of constructor
}
```

### Hint System

Adjust the hint system behavior:

```javascript
constructor() {
    // Hint system
    this.hintDelay = 5000; // Time (ms) before showing a hint
    // Rest of constructor
}

showHint() {
    // Make hints stay visible longer
    setTimeout(() => {
        this.clearHint();
    }, 5000); // Increase from 3000 to 5000ms
}
```

## Audio Settings

### Custom Sound Effects

To replace sound effects:

1. Add your audio files to the `assets/audio/` directory
2. Update the references in `audio.js`:

```javascript
const audioManager = {
    sounds: {
        swap: new Audio('assets/audio/your-swap-sound.mp3'),
        match: new Audio('assets/audio/your-match-sound.mp3'),
        invalid: new Audio('assets/audio/your-invalid-sound.mp3'),
        gameOver: new Audio('assets/audio/your-gameover-sound.mp3'),
        hint: new Audio('assets/audio/your-hint-sound.mp3')
    },
    // Rest of the code
};
```

### Background Music

To change the background music:

1. Replace `assets/audio/background-music.mp3` with your music file
2. Adjust the volume in `audio.js`:

```javascript
initMusic() {
    this.music = new Audio('assets/audio/your-background-music.mp3');
    this.music.loop = true;
    this.music.volume = 0.3; // Adjust between 0.0 and 1.0
}
```

## Candy Types

### Changing Candy Images

To customize the candy images:

1. Replace the image files in the `assets/` directory
2. Update the `candyTypes` array in the CandyGame constructor:

```javascript
this.candyTypes = [
    { type: 'star', image: 'assets/your-star.png', class: 'star' },
    { type: 'heart', image: 'assets/your-heart.png', class: 'heart' },
    // Add or modify candy types as needed
];
```

### Adding New Candy Types

To add a new candy type:

1. Add the new candy image to the `assets/` directory
2. Add a new entry to the `candyTypes` array:

```javascript
this.candyTypes = [
    // Existing candy types
    { type: 'newcandy', image: 'assets/newcandy.png', class: 'newcandy' }
];
```

3. Add a CSS class for the new candy type:

```css
.candy.newcandy {
    /* Custom styling for your new candy */
}
```

### Adjusting Candy Distribution

To make certain candy types more or less common, modify the `getRandomCandyType` method:

```javascript
getRandomCandyType(row, col) {
    let availableTypes = [...this.candyTypes];
    
    // Filter out certain types based on conditions
    
    // For weighted distribution:
    const rareCandies = ['rainbow', 'candy']; // Your rare candy types
    if (Math.random() > 0.8) { // 20% chance for rare candies
        return availableTypes.find(t => rareCandies.includes(t.type)) || 
               availableTypes[Math.floor(Math.random() * availableTypes.length)];
    }
    
    // Exclude rare candies from normal distribution
    const commonTypes = availableTypes.filter(t => !rareCandies.includes(t.type));
    return commonTypes[Math.floor(Math.random() * commonTypes.length)];
}
```

## Animations

### Candy Movement

Customize candy movement animations in CSS:

```css
.candy.falling {
    animation: fall-in 0.5s ease-in;
}

@keyframes fall-in {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
```

### Match Animations

Adjust the matching animation:

```css
.candy.matched {
    animation: match-animation 0.6s ease-out;
    z-index: 10;
}

@keyframes match-animation {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.8; }
    100% { transform: scale(0); opacity: 0; }
}
```

### Hint Animation

Modify the hint animation effect:

```css
.hint-animation {
    animation: hint-pulse 1.5s infinite;
    z-index: 10;
    box-shadow: 0 0 10px 3px #ffeb3b, 0 0 20px 6px rgba(255, 235, 59, 0.5);
}

@keyframes hint-pulse {
    0% { transform: scale(1); filter: brightness(1); }
    50% { transform: scale(1.1); filter: brightness(1.3); }
    100% { transform: scale(1); filter: brightness(1); }
}
```

## Advanced Customizations

### Adding New Features

#### Power-Ups

To add power-ups to the game:

1. Create power-up graphics and add them to the `assets/` directory
2. Define power-up types and behaviors in `game.js`:

```javascript
// Add to CandyGame class
constructor() {
    // Add powerup types
    this.powerUpTypes = {
        bomb: { radius: 1, effect: 'explosion' },
        lightning: { direction: 'vertical', length: 'full' },
        rainbow: { effect: 'clearColor' }
    };
}

// Create power-up creation logic
createPowerUp(type, row, col) {
    const candy = this.board[row][col];
    candy.dataset.powerup = type;
    candy.classList.add('power-up', type);
    
    // Add visual indicator
    const indicator = document.createElement('div');
    indicator.className = 'power-up-indicator';
    candy.appendChild(indicator);
}

// Activate power-up when matched or clicked
activatePowerUp(candy) {
    const type = candy.dataset.powerup;
    
    if (!type) return false;
    
    // Handle different power-up types
    switch(type) {
        case 'bomb':
            this.explodeBomb(candy);
            break;
        case 'lightning':
            this.triggerLightning(candy);
            break;
        case 'rainbow':
            this.clearColorFromBoard(candy);
            break;
    }
    
    return true;
}
```

3. Add corresponding CSS for power-ups:

```css
.power-up {
    position: relative;
}

.power-up-indicator {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: contain;
    pointer-events: none;
}

.power-up.bomb .power-up-indicator {
    background-image: url('assets/bomb-indicator.png');
}
```

#### Game Modes

To add different game modes:

1. Create a mode selection interface in HTML
2. Add game mode logic to the CandyGame class:

```javascript
// In the constructor
constructor() {
    this.gameMode = 'timed'; // Default mode
    // Other modes: 'moves', 'target', 'endless'
}

// Create a method to change the game mode
setGameMode(mode) {
    this.gameMode = mode;
    
    switch(mode) {
        case 'timed':
            this.maxTime = 60;
            this.showTimerBar = true;
            break;
        case 'moves':
            this.maxMoves = 30;
            this.movesLeft = this.maxMoves;
            this.showTimerBar = false;
            break;
        case 'target':
            this.targetScore = 1000;
            this.showTimerBar = true;
            this.maxTime = 120;
            break;
        case 'endless':
            this.showTimerBar = false;
            break;
    }
    
    // Update UI to reflect mode
    this.updateGameModeUI();
}
```

### Scoring System

#### Custom Scoring Rules

To customize how scores are calculated:

```javascript
// In the checkAndRemoveMatches method
async checkAndRemoveMatches() {
    const matches = this.findMatches();
    
    if (matches.length > 0) {
        // Custom scoring logic
        let points = 0;
        
        // Base points for each candy
        points += matches.length * 10;
        
        // Bonus for matches larger than 3
        if (matches.length > 3) {
            points += (matches.length - 3) * 20;
        }
        
        // Combo bonus for consecutive matches
        if (this.consecutiveMatches > 0) {
            points *= (1 + 0.1 * this.consecutiveMatches);
        }
        
        this.consecutiveMatches++;
        this.score += Math.floor(points);
        
        // Rest of the method
    } else {
        this.consecutiveMatches = 0;
    }
}
```

#### Score Multipliers

Add score multipliers based on various conditions:

```javascript
// Add to CandyGame class
constructor() {
    this.scoreMultiplier = 1;
    this.multiplierTimeout = null;
}

increaseMultiplier() {
    // Increase multiplier up to a maximum
    this.scoreMultiplier = Math.min(this.scoreMultiplier + 0.5, 4);
    
    // Update UI to show current multiplier
    this.updateMultiplierUI();
    
    // Reset multiplier after a delay
    clearTimeout(this.multiplierTimeout);
    this.multiplierTimeout = setTimeout(() => {
        this.scoreMultiplier = 1;
        this.updateMultiplierUI();
    }, 5000);
}

updateMultiplierUI() {
    const multiplierElement = document.getElementById('scoreMultiplier');
    if (multiplierElement) {
        multiplierElement.textContent = `×${this.scoreMultiplier.toFixed(1)}`;
        
        // Add animation when multiplier changes
        multiplierElement.classList.remove('pulse');
        void multiplierElement.offsetWidth; // Force reflow
        multiplierElement.classList.add('pulse');
    }
}
```

### Level System

#### Implementing Levels

To add a level progression system:

```javascript
// Add to CandyGame class
constructor() {
    this.currentLevel = 1;
    this.levelsData = [
        { target: 100, time: 60, boardSize: 6 },
        { target: 200, time: 55, boardSize: 6 },
        { target: 300, time: 50, boardSize: 7 },
        { target: 500, time: 60, boardSize: 7 },
        { target: 700, time: 55, boardSize: 8 },
        // Add more levels as needed
    ];
}

loadLevel(level) {
    // Get level data
    const levelIndex = level - 1;
    if (levelIndex >= this.levelsData.length) {
        // Handle case where level doesn't exist
        return false;
    }
    
    const levelData = this.levelsData[levelIndex];
    
    // Apply level settings
    this.boardSize = levelData.boardSize;
    this.maxTime = levelData.time;
    this.targetScore = levelData.target;
    
    // Update UI to show current level
    this.updateLevelUI();
    
    // Reset the board with new size
    this.createBoard();
    this.fillBoard();
    
    return true;
}

checkLevelCompletion() {
    if (this.score >= this.targetScore) {
        this.levelComplete();
    }
}

levelComplete() {
    // Pause game
    this.isPaused = true;
    
    // Show level complete popup
    const levelCompletePopup = document.createElement('div');
    levelCompletePopup.className = 'level-complete-popup';
    levelCompletePopup.innerHTML = `
        <h2>Level ${this.currentLevel} Complete!</h2>
        <p>Score: ${this.score}</p>
        <p>Target: ${this.targetScore}</p>
        <button id="nextLevelBtn">Next Level</button>
    `;
    
    document.body.appendChild(levelCompletePopup);
    
    // Set up button for next level
    document.getElementById('nextLevelBtn').addEventListener('click', () => {
        document.body.removeChild(levelCompletePopup);
        this.currentLevel++;
        this.loadLevel(this.currentLevel);
        this.isPaused = false;
    });
}
```

### Special Candies

#### Special Candy Effects

To create special candies with unique effects:

```javascript
// Add to the findMatches method
findMatches() {
    // Existing match finding code
    
    // Check for special patterns (L shape, T shape, etc.)
    for (let i = 0; i < this.boardSize - 2; i++) {
        for (let j = 0; j < this.boardSize - 2; j++) {
            // Example: Check for L shape matches
            const centerType = this.board[i+1][j+1].dataset.type;
            
            if (!centerType) continue;
            
            // Horizontal then vertical (L shape)
            if (this.board[i+1][j].dataset.type === centerType &&
                this.board[i+1][j+2].dataset.type === centerType &&
                this.board[i][j+1].dataset.type === centerType &&
                this.board[i+2][j+1].dataset.type === centerType) {
                
                // Create special candy at center
                this.createSpecialCandy('super', i+1, j+1);
                
                // Add all candies in the pattern to matches
                matches.add(this.board[i+1][j]);
                matches.add(this.board[i+1][j+1]);
                matches.add(this.board[i+1][j+2]);
                matches.add(this.board[i][j+1]);
                matches.add(this.board[i+2][j+1]);
            }
        }
    }
    
    return Array.from(matches);
}

createSpecialCandy(type, row, col) {
    const candy = this.board[row][col];
    
    // Set special candy properties
    candy.dataset.special = type;
    candy.classList.add('special-candy', type);
    
    // Update the image
    const img = candy.querySelector('img');
    if (img) {
        img.src = `assets/${type}-candy.png`;
    }
}

// Handle special candy activation
handleSpecialCandy(candy) {
    const specialType = candy.dataset.special;
    
    if (!specialType) return false;
    
    switch(specialType) {
        case 'super':
            this.activateSuperCandy(candy);
            break;
        case 'color-bomb':
            this.activateColorBomb(candy);
            break;
        // Add other special candy types
    }
    
    return true;
}

activateSuperCandy(candy) {
    const row = parseInt(candy.dataset.row);
    const col = parseInt(candy.dataset.col);
    
    // Get all candies in the row and column
    const affectedCandies = new Set();
    
    // Add row candies
    for (let j = 0; j < this.boardSize; j++) {
        affectedCandies.add(this.board[row][j]);
    }
    
    // Add column candies
    for (let i = 0; i < this.boardSize; i++) {
        affectedCandies.add(this.board[i][col]);
    }
    
    // Mark all affected candies as matched
    affectedCandies.forEach(candy => {
        candy.classList.add('matched');
    });
    
    // Process the matches
    this.processMatches(Array.from(affectedCandies));
}
```

## Mobile Optimization

### Touch Controls

The game already includes touch event handlers, but you can customize their behavior:

```javascript
// In the setupEventListeners method
this.gameBoard.addEventListener('touchstart', (e) => {
    // Custom touch handling
    // Add better touch feedback
    const candy = e.target.closest('.candy');
    if (candy) {
        candy.classList.add('touch-feedback');
    }
});

this.gameBoard.addEventListener('touchend', () => {
    // Remove touch feedback from all candies
    document.querySelectorAll('.candy.touch-feedback').forEach(candy => {
        candy.classList.remove('touch-feedback');
    });
});
```

Add corresponding CSS:

```css
.candy.touch-feedback {
    transform: scale(1.1);
    opacity: 0.8;
    z-index: 10;
}
```

### Responsive Layout

Improve the game's responsive behavior:

```css
/* Improved responsive layout */
@media (max-width: 768px) {
    .game-container {
        width: 95vw;
    }
    
    .board {
        width: 95vw;
        height: 95vw;
    }
    
    .candy {
        width: calc(95vw / 8);
        height: calc(95vw / 8);
    }
}

@media (max-width: 480px) {
    .header h1 {
        font-size: 1.5rem;
    }
    
    .score-display {
        padding: 0.3rem 0.8rem;
    }
    
    .play-button {
        padding: 0.6rem 2rem;
        font-size: 1.5rem;
    }
}

/* Landscape mode optimization */
@media (max-height: 500px) and (orientation: landscape) {
    .game-container {
        flex-direction: row;
    }
    
    .controls {
        flex-direction: column;
        margin-right: 1rem;
    }
    
    .board {
        width: 80vh;
        height: 80vh;
    }
    
    .candy {
        width: calc(80vh / 8);
        height: calc(80vh / 8);
    }
}
```

## Browser Compatibility

### Polyfills

For older browsers, you may need to add polyfills. Add this to your game.js file:

```javascript
// Polyfills for older browsers
if (!Array.from) {
    Array.from = function(iterable) {
        return [].slice.call(iterable);
    };
}

if (!Element.prototype.closest) {
    Element.prototype.closest = function(selector) {
        let el = this;
        while (el) {
            if (el.matches(selector)) {
                return el;
            }
            el = el.parentElement;
        }
        return null;
    };
}

if (!Element.prototype.matches) {
    Element.prototype.matches = Element.prototype.msMatchesSelector || 
                               Element.prototype.webkitMatchesSelector;
}
```

### Vendor Prefixes

Ensure CSS has proper vendor prefixes:

```css
.candy.matched {
    animation: match-animation 0.6s ease-out;
    -webkit-animation: match-animation 0.6s ease-out;
}

@keyframes match-animation {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.8; }
    100% { transform: scale(0); opacity: 0; }
}

@-webkit-keyframes match-animation {
    0% { -webkit-transform: scale(1); opacity: 1; }
    50% { -webkit-transform: scale(1.3); opacity: 0.8; }
    100% { -webkit-transform: scale(0); opacity: 0; }
}
```

## Performance Optimization

### Canvas Rendering

For better performance, especially on mobile devices, you can convert the game board to use Canvas instead of DOM elements:

```javascript
// Add to CandyGame class
createCanvasBoard() {
    // Create canvas element
    const canvas = document.createElement('canvas');
    canvas.width = this.boardSize * 60; // Adjust size as needed
    canvas.height = this.boardSize * 60;
    canvas.id = 'gameCanvas';
    
    // Replace board with canvas
    this.gameBoard.parentNode.replaceChild(canvas, this.gameBoard);
    this.gameBoard = canvas;
    this.ctx = canvas.getContext('2d');
    
    // Load candy images
    this.candyImages = {};
    const imageLoadPromises = this.candyTypes.map(candy => {
        return new Promise(resolve => {
            const img = new Image();
            img.onload = () => resolve();
            img.src = candy.image;
            this.candyImages[candy.type] = img;
        });
    });
    
    // Continue initialization after images load
    Promise.all(imageLoadPromises).then(() => {
        this.fillCanvasBoard();
        this.setupCanvasEvents();
    });
}

renderCanvasBoard() {
    // Clear canvas
    this.ctx.clearRect(0, 0, this.gameBoard.width, this.gameBoard.height);
    
    // Draw each candy
    const tileSize = this.gameBoard.width / this.boardSize;
    
    for (let i = 0; i < this.boardSize; i++) {
        for (let j = 0; j < this.boardSize; j++) {
            const candy = this.board[i][j];
            if (candy.type) {
                const img = this.candyImages[candy.type];
                
                // Draw candy image
                this.ctx.drawImage(
                    img, 
                    j * tileSize, 
                    i * tileSize,
                    tileSize,
                    tileSize
                );
                
                // Draw selection/animation state
                if (candy.isSelected) {
                    this.ctx.strokeStyle = '#FFFFFF';
                    this.ctx.lineWidth = 3;
                    this.ctx.strokeRect(
                        j * tileSize + 3,
                        i * tileSize + 3,
                        tileSize - 6,
                        tileSize - 6
                    );
                }
            }
        }
    }
}
```

### Asset Preloading

Improve load times by preloading assets:

```javascript
// Add to CandyGame class
preloadAssets() {
    return new Promise(resolve => {
        const assets = [];
        
        // Add all candy images
        this.candyTypes.forEach(candy => {
            assets.push(candy.image);
        });
        
        // Add audio files
        const audioFiles = [
            'assets/audio/background-music.mp3',
            'assets/audio/match.mp3',
            'assets/audio/swap.mp3',
            'assets/audio/invalid.mp3',
            'assets/audio/gameOver.mp3',
            'assets/audio/hint.mp3'
        ];
        
        assets.push(...audioFiles);
        
        // Track loading progress
        let loaded = 0;
        
        assets.forEach(asset => {
            if (asset.endsWith('.mp3') || 
                asset.endsWith('.wav') || 
                asset.endsWith('.ogg')) {
                // Preload audio
                const audio = new Audio();
                audio.addEventListener('canplaythrough', () => {
                    loaded++;
                    if (loaded === assets.length) resolve();
                }, { once: true });
                audio.src = asset;
            } else {
                // Preload image
                const img = new Image();
                img.addEventListener('load', () => {
                    loaded++;
                    if (loaded === assets.length) resolve();
                }, { once: true });
                img.src = asset;
            }
        });
    });
}
```

## Troubleshooting

### Common Issues

#### Audio Not Playing

If audio doesn't play:

1. Check that audio files exist in the correct location
2. Ensure the volume settings are not set to 0
3. Add user interaction requirement:

```javascript
// Add to init method
initializeAudio() {
    // Flag to track if audio has been initialized by user interaction
    this.audioInitialized = false;
    
    // Add a one-time listener for user interaction
    const initAudio = () => {
        if (!this.audioInitialized) {
            // Create a silent audio context to unlock audio
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const silentBuffer = audioContext.createBuffer(1, 1, 22050);
            const source = audioContext.createBufferSource();
            source.buffer = silentBuffer;
            source.connect(audioContext.destination);
            source.start();
            
            this.audioInitialized = true;
            console.log('Audio initialized by user interaction');
            
            // Initialize audio manager
            audioManager.init();
        }
        
        // Remove event listeners
        document.removeEventListener('click', initAudio);
        document.removeEventListener('touchstart', initAudio);
        document.removeEventListener('keydown', initAudio);
    };
    
    document.addEventListener('click', initAudio);
    document.addEventListener('touchstart', initAudio);
    document.addEventListener('keydown', initAudio);
}

#### Performance Issues

If the game runs slowly:

1. Reduce the number of animations or their complexity
2. Consider implementing the Canvas-based rendering option described in the Performance Optimization section
3. Reduce the board size for lower-end devices
4. Ensure images are properly optimized and sized

#### Responsive Design Issues

If the game doesn't display correctly on certain devices:

1. Check the CSS media queries to ensure they cover the device's dimensions
2. Test with different viewport settings in your browser's developer tools
3. Add additional media queries as needed for specific devices

### Debugging Tips

- Use `console.log()` statements to track game state and behavior
- Inspect the DOM structure using browser developer tools to understand rendering issues
- Use breakpoints to step through game logic for complex bugs
- Verify localStorage access for score saving issues
