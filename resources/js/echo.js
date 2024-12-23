import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


window.Echo.channel('message')
    .listen('MessageEvent', (e) => {
        console.log(e);

        const messageList = document.getElementById('messageList');
        const messageCount = document.getElementById('messageCount'); 

        
        let currentCount = parseInt(messageCount.textContent) || 0;

        
        currentCount++;

        
        messageCount.textContent = currentCount;

       
        const newMessage = document.createElement('li');

        
        const newAnchor = document.createElement('a');
        newAnchor.classList.add('dropdown-item');
        newAnchor.href = `/read/${e.message.id}`;

        
        const messageContent = document.createElement('div');
        messageContent.classList.add('d-flex');

      
        const newImage = document.createElement('img');
        newImage.src = e.message.image;
        newImage.width = 100;
        newImage.alt = "Message Image";

       
        const messageText = document.createTextNode(e.message.text);

        
        messageContent.appendChild(newImage);
        messageContent.appendChild(messageText);

        
        newAnchor.appendChild(messageContent);

      
        newMessage.appendChild(newAnchor);

        
        messageList.prepend(newMessage);
    });
