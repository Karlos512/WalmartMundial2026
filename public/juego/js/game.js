/*
  © 2025 Techxedo. All rights reserved.
  This JavaScript file is part of a copyrighted HTML5 game.
*/

import audioManager from "./audio.js";

/*export default */

class CandyGame {
  constructor() {
    this.board = [];
    this.boardSize = 8;
    this.score = 0;
    this.bestScore = localStorage.getItem("bestScore") || 0;
    this.selectedCandy = null;
    this.isSwapping = false;
    this.isAnimating = false;
    this.isPaused = false;
    this.gameActive = false; // Game not active until play button clicked

    this.scoreSaved = false; //agregamos paa el save score

    // Timer settings
    this.maxTime = 60; // 60 seconds starting time
    this.currentTime = this.maxTime;
    this.timeDecreaseRate = 1; // time decrease per second
    this.timeIncreasePerMatch = 2; // time increase per candy matched
    this.timerInterval = null;

    // Hint system
    this.hintDelay = 5000; // 5 seconds of inactivity
    this.hintTimeout = null;
    this.currentHint = null;
    this.lastMoveTime = Date.now();

    // Initialize hint checking interval
    this.hintCheckInterval = null;

    this.candyTypes = [
      { type: "star", image: "./juego/assets/star.png", class: "star" },
      { type: "heart", image: "./juego/assets/heart.png", class: "heart" },
      { type: "circle", image: "./juego/assets/circle.png", class: "circle" },
      { type: "cube", image: "./juego/assets/cube.png", class: "cube" },
      { type: "diamond", image: "./juego/assets/diamond.png", class: "diamond" },
      { type: "bubble", image: "./juego/assets/bubble.png", class: "bubble" },
      { type: "aqua", image: "./juego/assets/aqua.png", class: "aqua" },
      { type: "rainbow", image: "./juego/assets/rainbow.png", class: "rainbow" },
      { type: "candy", image: "./juego/assets/candy.png", class: "candy-special" },
    ];

    // DOM Elements
    this.welcomeScreen = document.getElementById("welcomeScreen");
    this.startBtn = document.getElementById("startBtn");
    this.gameContainer = document.getElementById("gameContainer");
    this.gameBoard = document.getElementById("board");
    this.currentScoreElement = document.getElementById("currentScore");
    this.bestScoreElement = document.getElementById("bestScore");
    this.gameOverElement = document.getElementById("gameOver");
    this.finalScoreElement = document.getElementById("finalScore");
    // this.highScoreElement = document.getElementById("highScore");
    this.musicBtn = document.getElementById("musicToggleBtn");
    this.soundBtn = document.getElementById("soundToggleBtn");
    // this.pauseBtn = document.getElementById("pauseBtn");
    // this.restartBtn = document.getElementById("restartBtn");
    this.timerBar = document.getElementById("timerBar");
    this.timer = document.getElementById("timer");

    // Drag variables
    this.draggedCandy = null;
    this.dragStartX = 0;
    this.dragStartY = 0;
    this.lastInteractionTime = Date.now();

    this.init();
  }

  init() {
    // Set up welcome screen event
    this.startBtn.addEventListener("click", () => {
      this.startGame();
    });

    // this.restartBtn.addEventListener("click", () => {
    //   this.restart();
    // });

    this.createBoard();
    this.updateScores();
    this.setupEventListeners();

    // Initialize audio
    if (!audioManager.isInitialized) {
      audioManager.init();
    }
  }

  setupHintSystem() {
    // Clear any existing interval
    if (this.hintCheckInterval) {
      clearInterval(this.hintCheckInterval);
    }

    // Set up an interval to check for inactivity and show hints
    this.hintCheckInterval = setInterval(() => {
      if (
        !this.gameActive ||
        this.isPaused ||
        this.isSwapping ||
        this.isAnimating
      ) {
        return; // Don't show hints if game is not in a playing state
      }

      const now = Date.now();
      const timeSinceLastMove = now - this.lastMoveTime;

      // Show hint after the hint delay time
      if (timeSinceLastMove > this.hintDelay && !this.currentHint) {
        this.showHint();
      }
    }, 15000); // Check every 15 seconds
  }

  showHint() {
    // Clear any existing hint first
    this.clearHint();

    // Find all valid moves on the current board
    const validMove = this.findValidMove();

    if (validMove) {
      // console.log("Showing hint for valid move:",
      //     validMove.candy1.dataset.row, validMove.candy1.dataset.col,
      //     validMove.candy2.dataset.row, validMove.candy2.dataset.col);

      // Store current hint to clear later
      this.currentHint = [validMove.candy1, validMove.candy2];

      // Add hint animation to the candies
      validMove.candy1.classList.add("hint-animation");
      validMove.candy2.classList.add("hint-animation");

      // Play hint sound if available
      if (audioManager && audioManager.playSound) {
        audioManager.playSound("hint");
      }

      // Auto-clear hint after 3 seconds
      setTimeout(() => {
        this.clearHint();
      }, 3000);
    } else {
      // console.log("No valid moves found for hint");
      // If no valid moves, shuffle the board
      if (this.gameActive) {
        this.shuffleBoard();
      }
    }
  }

  findValidMove() {
    // Check all possible swaps to find valid moves
    for (let row = 0; row < this.boardSize; row++) {
      for (let col = 0; col < this.boardSize; col++) {
        // Check right swap
        if (col < this.boardSize - 1) {
          if (this.wouldMakeMatch(row, col, row, col + 1)) {
            return {
              candy1: this.board[row][col],
              candy2: this.board[row][col + 1],
            };
          }
        }

        // Check down swap
        if (row < this.boardSize - 1) {
          if (this.wouldMakeMatch(row, col, row + 1, col)) {
            return {
              candy1: this.board[row][col],
              candy2: this.board[row + 1][col],
            };
          }
        }
      }
    }

    return null;
  }

  wouldMakeMatch(row1, col1, row2, col2) {
    // Get current types
    const type1 = this.board[row1][col1].dataset.type;
    const type2 = this.board[row2][col2].dataset.type;

    if (!type1 || !type2) return false;

    // Temporarily swap types
    this.board[row1][col1].dataset.type = type2;
    this.board[row2][col2].dataset.type = type1;

    // Check if the swap creates a match
    let createsMatch = false;

    // Check for matches around the first position
    if (this.checkForMatchAt(row1, col1)) {
      createsMatch = true;
    }

    // Check for matches around the second position
    if (!createsMatch && this.checkForMatchAt(row2, col2)) {
      createsMatch = true;
    }

    // Restore original types
    this.board[row1][col1].dataset.type = type1;
    this.board[row2][col2].dataset.type = type2;

    return createsMatch;
  }

  checkForMatchAt(row, col) {
    const type = this.board[row][col].dataset.type;

    // Check horizontal match (at least 3 in a row)
    let horizontalCount = 1;
    let leftCount = 0;
    let rightCount = 0;

    // Count to the left
    for (let c = col - 1; c >= 0; c--) {
      if (this.board[row][c].dataset.type === type) {
        leftCount++;
      } else {
        break;
      }
    }

    // Count to the right
    for (let c = col + 1; c < this.boardSize; c++) {
      if (this.board[row][c].dataset.type === type) {
        rightCount++;
      } else {
        break;
      }
    }

    horizontalCount += leftCount + rightCount;
    if (horizontalCount >= 3) return true;

    // Check vertical match (at least 3 in a column)
    let verticalCount = 1;
    let upCount = 0;
    let downCount = 0;

    // Count up
    for (let r = row - 1; r >= 0; r--) {
      if (this.board[r][col].dataset.type === type) {
        upCount++;
      } else {
        break;
      }
    }

    // Count down
    for (let r = row + 1; r < this.boardSize; r++) {
      if (this.board[r][col].dataset.type === type) {
        downCount++;
      } else {
        break;
      }
    }

    verticalCount += upCount + downCount;
    if (verticalCount >= 3) return true;

    return false;
  }

  shuffleBoard() {
    // console.log("Shuffling board due to no valid moves");

    // Show shuffling message
    const shuffleMsg = document.createElement("div");
    shuffleMsg.className = "shuffle-message";
    shuffleMsg.textContent = "Sin combinacines - Reacomodando!";
    document.body.appendChild(shuffleMsg);

    setTimeout(() => {
      // Collect all current candy types
      const allCandies = [];
      for (let i = 0; i < this.boardSize; i++) {
        for (let j = 0; j < this.boardSize; j++) {
          const candy = this.board[i][j];
          if (candy.dataset.type) {
            allCandies.push({
              type: candy.dataset.type,
              class: candy.className.replace("hint-animation", "").trim(),
            });
          }
        }
      }

      // Shuffle the array of candy types
      for (let i = allCandies.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [allCandies[i], allCandies[j]] = [allCandies[j], allCandies[i]];
      }

      // Re-apply to the board
      let candyIndex = 0;
      for (let i = 0; i < this.boardSize; i++) {
        for (let j = 0; j < this.boardSize; j++) {
          const candy = this.board[i][j];
          if (candy.dataset.type) {
            const newCandy = allCandies[candyIndex++];

            // Get existing image
            const img = candy.querySelector("img");
            if (img) {
              // Update image source based on new type
              const candyInfo = this.candyTypes.find(
                (c) => c.type === newCandy.type
              );
              if (candyInfo) {
                img.src = candyInfo.image;
                img.alt = candyInfo.type;
              }
            }

            candy.dataset.type = newCandy.type;
            candy.className = newCandy.class + " shuffling";

            // Add a randomized animation delay
            const delay = Math.random() * 0.5;
            candy.style.animationDelay = `${delay}s`;
          }
        }
      }

      // Remove shuffle message
      setTimeout(() => {
        if (document.body.contains(shuffleMsg)) {
          document.body.removeChild(shuffleMsg);
        }

        // Remove shuffling class after animation completes
        setTimeout(() => {
          for (let i = 0; i < this.boardSize; i++) {
            for (let j = 0; j < this.boardSize; j++) {
              this.board[i][j].classList.remove("shuffling");
              this.board[i][j].style.animationDelay = "";
            }
          }

          // Check if the shuffled board has valid moves
          if (!this.findValidMove()) {
            // If still no valid moves, fill with new candies
            this.fillBoard();
          }

          // Reset interaction time
          this.updateLastInteractionTime();
        }, 800);
      }, 1500);
    }, 500);
  }

  clearHint() {
    // Remove hint animation from all candies
    if (this.currentHint) {
      this.currentHint.forEach((candy) => {
        candy.classList.remove("hint-animation");
      });
      this.currentHint = null;
    }
  }

  startGame() {
    // console.log('Starting game...');
    // Fade out welcome screen
    this.welcomeScreen.style.opacity = "0";

    // Set flag to track user interaction
    this.userInteracted = true;

    setTimeout(() => {
      this.welcomeScreen.style.display = "none";

      // Show game container
      this.gameContainer.classList.add("visible");

      // Initialize the game
      this.gameActive = true;
      this.fillBoard();
      this.startTimer();
      this.setupHintSystem();

      // console.log('Game started, attempting to play music');

      // Play music
      if (audioManager && typeof audioManager.playMusic === "function") {
        audioManager.playMusic();
      }

      // Initial board check for matches after a delay
      setTimeout(() => {
        this.checkAndRemoveMatches();
      }, 500);
    }, 500);
  }

  startTimer() {
    if (this.timerInterval) {
      clearInterval(this.timerInterval);
    }

    this.currentTime = this.maxTime;
    this.updateTimerBar();

    this.timerInterval = setInterval(() => {
      if (this.isPaused || !this.gameActive) return;

      // Check if user has been inactive for more than 2 seconds
      const now = Date.now();
      const timeSinceLastInteraction = (now - this.lastInteractionTime) / 1000;

      // Decrease time faster if player is inactive
      if (timeSinceLastInteraction > 2) {
        this.currentTime -= this.timeDecreaseRate * 1.5;
      } else {
        this.currentTime -= this.timeDecreaseRate;
      }

      // Update timer bar
      this.updateTimerBar();

      // Check if time's up
      if (this.currentTime <= 0) {
        this.gameOver();
      }
    }, 1000);
  }

  updateTimerBar() {
    // Calculate percentage of time left
    const percentage = (this.currentTime / this.maxTime) * 100;
    this.timerBar.style.width = `${percentage}%`;

    if (this.timer) {
      this.timer.innerText = Math.max(0, Math.ceil(this.currentTime));
    }

    // Change color based on time left
    this.timerBar.classList.remove("warning", "danger");
    if (percentage < 20) {
      this.timerBar.classList.add("danger");
    } else if (percentage < 50) {
      this.timerBar.classList.add("warning");
    }
  }

  updateLastInteractionTime() {
    this.lastInteractionTime = Date.now();
    this.lastMoveTime = Date.now(); // Update for hint system
  }

  addTime(matches) {
    // Add time based on number of candies matched
    const timeToAdd = matches.length * this.timeIncreasePerMatch;
    this.currentTime = Math.min(this.currentTime + timeToAdd, this.maxTime);
    this.updateTimerBar();

    // Show visual feedback for time added
    this.showTimeAddedFeedback(timeToAdd);
  }

  showTimeAddedFeedback(secondsAdded) {
    // Create a floating text element to show time added
    const feedback = document.createElement("div");
    feedback.classList.add("time-feedback");
    feedback.textContent = `+${secondsAdded}s`;

    const timerContainer = this.timerBar.parentNode;
    timerContainer.appendChild(feedback);

    // Animate and remove after animation
    setTimeout(() => {
      feedback.classList.add("fade-out");
      setTimeout(() => {
        if (timerContainer.contains(feedback)) {
          timerContainer.removeChild(feedback);
        }
      }, 1000);
    }, 100);
  }

  createBoard() {
    this.gameBoard.innerHTML = "";
    this.board = [];

    for (let i = 0; i < this.boardSize; i++) {
      this.board[i] = [];
      for (let j = 0; j < this.boardSize; j++) {
        const candy = document.createElement("div");
        candy.className = "candy";
        candy.dataset.row = i;
        candy.dataset.col = j;
        this.gameBoard.appendChild(candy);
        this.board[i][j] = candy;
      }
    }
  }

  fillBoard() {
    for (let i = 0; i < this.boardSize; i++) {
      for (let j = 0; j < this.boardSize; j++) {
        if (!this.board[i][j].querySelector("img")) {
          const randomType = this.getRandomCandyType(i, j);
          const candy = this.board[i][j];
          const img = document.createElement("img");
          img.src = randomType.image;
          img.alt = randomType.type;
          candy.innerHTML = "";
          candy.appendChild(img);
          candy.dataset.type = randomType.type;

          // Reset any existing classes and add new ones
          candy.className = "candy";
          candy.classList.add(randomType.class);
          candy.classList.add("falling");

          // Remove falling class after animation completes
          setTimeout(() => {
            if (candy.classList.contains("falling")) {
              candy.classList.remove("falling");
            }
          }, 500);
        }
      }
    }
  }

  getRandomCandyType(row, col) {
    let availableTypes = [...this.candyTypes];

    // Check vertical matches
    if (row >= 2) {
      const type1 = this.getCandyType(this.board[row - 1][col]);
      const type2 = this.getCandyType(this.board[row - 2][col]);
      if (type1 && type2 && type1 === type2) {
        availableTypes = availableTypes.filter((t) => t.type !== type1);
      }
    }

    // Check horizontal matches
    if (col >= 2) {
      const type1 = this.getCandyType(this.board[row][col - 1]);
      const type2 = this.getCandyType(this.board[row][col - 2]);
      if (type1 && type2 && type1 === type2) {
        availableTypes = availableTypes.filter((t) => t.type !== type1);
      }
    }

    // If no available types (which shouldn't happen normally), use all types
    if (availableTypes.length === 0) {
      availableTypes = [...this.candyTypes];
    }

    return availableTypes[Math.floor(Math.random() * availableTypes.length)];
  }

  getCandyType(candy) {
    return candy.dataset.type || null;
  }

  setupEventListeners() {
    this.gameBoard.addEventListener("mousedown", (e) => {
      if (!this.gameActive || this.isPaused) return;

      const candy = e.target.closest(".candy");
      if (!candy || this.isSwapping || this.isAnimating) return;

      this.updateLastInteractionTime();
      this.draggedCandy = candy;
      this.dragStartX = e.clientX;
      this.dragStartY = e.clientY;
      candy.classList.add("selected");
    });

    this.gameBoard.addEventListener("mousemove", (e) => {
      if (!this.gameActive || this.isPaused) return;
      if (!this.draggedCandy || this.isSwapping || this.isAnimating) return;

      this.updateLastInteractionTime();
      const deltaX = e.clientX - this.dragStartX;
      const deltaY = e.clientY - this.dragStartY;
      const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);

      if (distance > 20) {
        // Minimum drag distance
        const angle = (Math.atan2(deltaY, deltaX) * 180) / Math.PI;
        const direction = this.getSwipeDirection(angle);
        const targetCandy = this.getAdjacentCandy(this.draggedCandy, direction);

        if (targetCandy) {
          this.draggedCandy.classList.add("dragging");
          this.swapCandies(this.draggedCandy, targetCandy);
          this.draggedCandy.classList.remove("selected", "dragging");
          this.draggedCandy = null;
        }
      }
    });

    this.gameBoard.addEventListener("mouseup", () => {
      if (!this.gameActive || this.isPaused) return;

      if (this.draggedCandy) {
        this.updateLastInteractionTime();
        this.draggedCandy.classList.remove("selected", "dragging");
        this.draggedCandy = null;
      }
    });

    this.gameBoard.addEventListener("mouseleave", () => {
      if (!this.gameActive || this.isPaused) return;

      if (this.draggedCandy) {
        this.updateLastInteractionTime();
        this.draggedCandy.classList.remove("selected", "dragging");
        this.draggedCandy = null;
      }
    });

    // Keep the click handler for mobile/touch devices
    this.gameBoard.addEventListener("click", (e) => {
      if (!this.gameActive || this.isPaused) return;
      if (this.isSwapping || this.isAnimating) return;

      const candy = e.target.closest(".candy");
      if (!candy) return;

      this.updateLastInteractionTime();

      if (!this.selectedCandy) {
        this.selectedCandy = candy;
        candy.classList.add("selected");
      } else {
        const row1 = parseInt(this.selectedCandy.dataset.row);
        const col1 = parseInt(this.selectedCandy.dataset.col);
        const row2 = parseInt(candy.dataset.row);
        const col2 = parseInt(candy.dataset.col);

        if (this.isAdjacent(row1, col1, row2, col2)) {
          candy.classList.add("selected");
          this.swapCandies(this.selectedCandy, candy);
          setTimeout(() => {
            if (candy.classList.contains("selected")) {
              candy.classList.remove("selected");
            }
          }, 300);
        }

        this.selectedCandy.classList.remove("selected");
        this.selectedCandy = null;
      }
    });

    // Touch events for mobile devices
    this.gameBoard.addEventListener("touchstart", (e) => {
      if (!this.gameActive || this.isPaused) return;

      const candy = e.target.closest(".candy");
      if (!candy || this.isSwapping || this.isAnimating) return;

      this.updateLastInteractionTime();
      this.draggedCandy = candy;
      this.dragStartX = e.touches[0].clientX;
      this.dragStartY = e.touches[0].clientY;
      candy.classList.add("selected");
    });

    this.gameBoard.addEventListener("touchmove", (e) => {
      if (!this.gameActive || this.isPaused) return;
      if (!this.draggedCandy || this.isSwapping || this.isAnimating) return;
      e.preventDefault();

      this.updateLastInteractionTime();
      const deltaX = e.touches[0].clientX - this.dragStartX;
      const deltaY = e.touches[0].clientY - this.dragStartY;
      const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);

      if (distance > 20) {
        const angle = (Math.atan2(deltaY, deltaX) * 180) / Math.PI;
        const direction = this.getSwipeDirection(angle);
        const targetCandy = this.getAdjacentCandy(this.draggedCandy, direction);

        if (targetCandy) {
          this.draggedCandy.classList.add("dragging");
          this.swapCandies(this.draggedCandy, targetCandy);
          this.draggedCandy.classList.remove("selected", "dragging");
          this.draggedCandy = null;
        }
      }
    });

    this.gameBoard.addEventListener("touchend", () => {
      if (!this.gameActive || this.isPaused) return;

      if (this.draggedCandy) {
        this.updateLastInteractionTime();
        this.draggedCandy.classList.remove("selected", "dragging");
        this.draggedCandy = null;
      }
    });

    // this.pauseBtn.addEventListener("click", () => {
    //   this.togglePause();
    // });
  }

  togglePause() {
    if (!this.gameActive) return;

    this.isPaused = !this.isPaused;
    // this.pauseBtn.classList.toggle("play");

    if (this.isPaused) {
      // Show pause overlay
      const pauseOverlay = document.createElement("div");
      pauseOverlay.id = "pauseOverlay";
      pauseOverlay.className = "pause-overlay";
      pauseOverlay.innerHTML = '<div class="pause-text">PAUSED</div>';
      this.gameBoard.parentNode.appendChild(pauseOverlay);

      // Pause audio
      audioManager.pauseMusic();
    } else {
      // Remove pause overlay
      const pauseOverlay = document.getElementById("pauseOverlay");
      if (pauseOverlay) {
        pauseOverlay.remove();
      }

      // Resume audio
      audioManager.resumeMusic();

      this.updateLastInteractionTime(); // Reset the inactivity timer
    }
  }

  isAdjacent(row1, col1, row2, col2) {
    return (
      (Math.abs(row1 - row2) === 1 && col1 === col2) ||
      (Math.abs(col1 - col2) === 1 && row1 === row2)
    );
  }

  async swapCandies(candy1, candy2) {
    if (this.isSwapping || !this.gameActive || this.isPaused) return;
    this.isSwapping = true;

    // Clear any hint when user makes a move
    this.clearHint();
    this.updateLastInteractionTime();

    // Get positions for animation
    const rect1 = candy1.getBoundingClientRect();
    const rect2 = candy2.getBoundingClientRect();

    // Calculate the translation distances
    const deltaX = rect2.left - rect1.left;
    const deltaY = rect2.top - rect1.top;

    // Animate the swap
    candy1.style.transition = "transform 0.3s ease-in-out";
    candy2.style.transition = "transform 0.3s ease-in-out";

    candy1.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
    candy2.style.transform = `translate(${-deltaX}px, ${-deltaY}px)`;

    // Play swap sound
    audioManager.playSound("swap");

    // Wait for animation to complete
    await new Promise((resolve) => setTimeout(resolve, 300));

    // Reset transforms
    candy1.style.transition = "";
    candy2.style.transition = "";
    candy1.style.transform = "";
    candy2.style.transform = "";

    // Swap the actual content and data
    const temp = {
      html: candy1.innerHTML,
      type: candy1.dataset.type,
      class: candy1.className,
    };

    candy1.innerHTML = candy2.innerHTML;
    candy1.dataset.type = candy2.dataset.type;
    candy1.className = candy2.className;

    candy2.innerHTML = temp.html;
    candy2.dataset.type = temp.type;
    candy2.className = temp.class;

    // Check for matches
    if (!(await this.checkAndRemoveMatches())) {
      // Play invalid sound
      audioManager.playSound("invalid");

      // Animate swapping back
      candy1.style.transition = "transform 0.3s ease-in-out";
      candy2.style.transition = "transform 0.3s ease-in-out";

      candy1.style.transform = `translate(${deltaX}px, ${deltaY}px)`;
      candy2.style.transform = `translate(${-deltaX}px, ${-deltaY}px)`;

      await new Promise((resolve) => setTimeout(resolve, 300));

      // Reset transforms
      candy1.style.transition = "";
      candy2.style.transition = "";
      candy1.style.transform = "";
      candy2.style.transform = "";

      // Swap back content
      candy2.innerHTML = candy1.innerHTML;
      candy2.dataset.type = candy1.dataset.type;
      candy2.className = candy1.className;

      candy1.innerHTML = temp.html;
      candy1.dataset.type = temp.type;
      candy1.className = temp.class;
    }

    this.isSwapping = false;
  }

  async checkAndRemoveMatches() {
    const matches = this.findMatches();

    if (matches.length > 0) {
      this.isAnimating = true;

      // Update score
      this.score += matches.length * 10;
      this.updateScores();

      // Play match sound
      audioManager.playSound("match");

      // Add time based on matches
      this.addTime(matches);

      // Add matched animation class to all matched candies
      matches.forEach((candy) => {
        candy.classList.add("matched");
      });

      // Wait for animation to complete
      await new Promise((resolve) => setTimeout(resolve, 600));

      // Remove matches
      matches.forEach((candy) => {
        candy.innerHTML = "";
        candy.className = "candy";
        candy.dataset.type = "";
      });

      // Fill empty spaces with new candies
      await this.fillBoard();

      // Check for cascading matches
      setTimeout(async () => {
        if (this.gameActive) {
          await this.checkAndRemoveMatches();
        }
        this.isAnimating = false;
      }, 500);

      return true;
    }

    this.isAnimating = false;
    return false;
  }

  findMatches() {
    const matches = new Set();

    // Check horizontal matches
    for (let i = 0; i < this.boardSize; i++) {
      for (let j = 0; j < this.boardSize - 2; j++) {
        const candy1 = this.board[i][j];
        const candy2 = this.board[i][j + 1];
        const candy3 = this.board[i][j + 2];

        if (
          candy1.dataset.type &&
          candy1.dataset.type === candy2.dataset.type &&
          candy1.dataset.type === candy3.dataset.type
        ) {
          matches.add(candy1);
          matches.add(candy2);
          matches.add(candy3);

          // Check for longer matches (4 in a row)
          if (j + 3 < this.boardSize) {
            const candy4 = this.board[i][j + 3];
            if (candy1.dataset.type === candy4.dataset.type) {
              matches.add(candy4);

              // Check for 5 in a row
              if (j + 4 < this.boardSize) {
                const candy5 = this.board[i][j + 4];
                if (candy1.dataset.type === candy5.dataset.type) {
                  matches.add(candy5);
                }
              }
            }
          }
        }
      }
    }

    // Check vertical matches
    for (let i = 0; i < this.boardSize - 2; i++) {
      for (let j = 0; j < this.boardSize; j++) {
        const candy1 = this.board[i][j];
        const candy2 = this.board[i + 1][j];
        const candy3 = this.board[i + 2][j];

        if (
          candy1.dataset.type &&
          candy1.dataset.type === candy2.dataset.type &&
          candy1.dataset.type === candy3.dataset.type
        ) {
          matches.add(candy1);
          matches.add(candy2);
          matches.add(candy3);

          // Check for longer matches (4 in a row)
          if (i + 3 < this.boardSize) {
            const candy4 = this.board[i + 3][j];
            if (candy1.dataset.type === candy4.dataset.type) {
              matches.add(candy4);

              // Check for 5 in a row
              if (i + 4 < this.boardSize) {
                const candy5 = this.board[i + 4][j];
                if (candy1.dataset.type === candy5.dataset.type) {
                  matches.add(candy5);
                }
              }
            }
          }
        }
      }
    }

    return Array.from(matches);
  }

  updateScores() {
    this.currentScoreElement.textContent = this.score;
    if (this.score > this.bestScore) {
      this.bestScore = this.score;
      localStorage.setItem("bestScore", this.bestScore);
    }
    this.bestScoreElement.textContent = this.bestScore;
  }

  gameOver() {

      this.gameActive = false;

      clearInterval(this.timerInterval);

      if (this.hintCheckInterval) {
          clearInterval(this.hintCheckInterval);
      }

      this.clearHint();

      this.gameOverElement.classList.remove("hidden");

      this.finalScoreElement.textContent = this.score;

      if (!this.scoreSaved && window.Livewire) {

          this.scoreSaved = true;

          Livewire.dispatch('guardar-score', {
              score: this.score
          });

      }

      audioManager.playSound("gameOver");

      audioManager.pauseMusic();

  }

  restart() {
    // Reset all game state
    this.score = 0;
    this.updateScores();
    this.gameOverElement.classList.add("hidden");

    // Reset pause button if needed
    if (this.isPaused) {
      this.isPaused = false;
      //   this.pauseBtn.classList.remove("play");

      // Remove any pause overlay
      const pauseOverlay = document.getElementById("pauseOverlay");
      if (pauseOverlay) {
        pauseOverlay.remove();
      }
    }

    // Reset the board
    this.createBoard();
    this.gameActive = true;
    this.fillBoard();

    // Reset and start the timer
    this.startTimer();

    // Update the last interaction time
    this.updateLastInteractionTime();

    // Resume music
    audioManager.playMusic("background");

    // Reset and restart hint system
    this.lastMoveTime = Date.now();
    this.setupHintSystem();
  }

  destroy() {

      this.gameActive = false;
      clearInterval(this.timerInterval);
      clearInterval(this.hintCheckInterval);

      this.clearHint();

      audioManager.pauseMusic();
    }

  getSwipeDirection(angle) {
    if (angle < -135 || angle > 135) return "left";
    if (angle > -135 && angle < -45) return "up";
    if (angle > -45 && angle < 45) return "right";
    return "down";
  }

  getAdjacentCandy(candy, direction) {
    const row = parseInt(candy.dataset.row);
    const col = parseInt(candy.dataset.col);

    switch (direction) {
      case "left":
        return col > 0 ? this.board[row][col - 1] : null;
      case "right":
        return col < this.boardSize - 1 ? this.board[row][col + 1] : null;
      case "up":
        return row > 0 ? this.board[row - 1][col] : null;
      case "down":
        return row < this.boardSize - 1 ? this.board[row + 1][col] : null;
      default:
        return null;
    }
  }
}

// Audio Manager Stub (in case audio.js isn't available)
if (typeof audioManager === "undefined") {
  window.audioManager = {
    playSound: function (sound) {
      console.log("Playing sound:", sound);
    },
    playMusic: function (music) {
      console.log("Playing music:", music);
    },
    pauseMusic: function () {
      console.log("Music paused");
    },
    resumeMusic: function () {
      console.log("Music resumed");
    },
    toggleSound: function () {
      this.isSoundEnabled = !this.isSoundEnabled;
    },
    toggleMusic: function () {
      this.isMusicEnabled = !this.isMusicEnabled;
    },
    isSoundEnabled: true,
    isMusicEnabled: true,
  };
}

// Initialize the game when the DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  const game = new CandyGame();
});

window.CandyGame = CandyGame;