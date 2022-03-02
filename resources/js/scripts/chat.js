import { watchAwaitSelector } from './functions';

window.addEventListener('load', (event) => {
    start(event);
});


function start(event) {
    
    watchAwaitSelector(function(elements) {
        let openButton = elements[0];
        let chats = document.querySelectorAll('.chat');
    
        for(let chat of chats) {
            chat.addEventListener('click', function() {
                openButton.click();
            });
        }
    }, ' #openChatBtn');
    
}