document.addEventListener("contextmenu", event => event.preventDefault());
document.onkeydown = function (e) {
    if (e.keyCode == 123) return false; // F12
    if (e.ctrlKey && e.shiftKey && e.keyCode == 73) return false; // Ctrl+Shift+I
    if (e.ctrlKey && e.keyCode == 85) return false; // Ctrl+U
};
