$(document).ready(function() {
    const $movableButton = $('#movableButton');
    const $container = $('.container');
    let position = { top: 0, left: 0 };
    
    const moveButton = (dx, dy) => {
        const newTop = position.top + dy;
        const newLeft = position.left + dx;
        
        if (newTop >= 0 && newTop <= $container.height() - 50) {
            position.top = newTop;
        }
        if (newLeft >= 0 && newLeft <= $container.width() - 23) {
            position.left = newLeft;
        }
        
        updateButtonPosition();
    };
    
    const updateButtonPosition = () => {
        $movableButton.stop().animate({
            top: position.top + 'px',
            left: position.left + 'px'
        }, 200); // Animation duration set to 200 milliseconds
    };
    
    $('#upButton').click(() => moveButton(0, -10));
    $('#downButton').click(() => moveButton(0, 10));
    $('#leftButton').click(() => moveButton(-10, 0));
    $('#rightButton').click(() => moveButton(10, 0));
    
    let autoMoveInterval;
    $('#autoButton').click(() => {
        if (autoMoveInterval) {
            clearInterval(autoMoveInterval);
            autoMoveInterval = null;
        } else {
            autoMoveInterval = setInterval(() => {
                const direction = Math.floor(Math.random() * 4);
                switch (direction) {
                    case 0: moveButton(0, -50); break; // Up
                    case 1: moveButton(0, 50); break; // Down
                    case 2: moveButton(-50, 0); break; // Left
                    case 3: moveButton(50, 0); break; // Right
                }
            }, 500);
        }
    });
});
