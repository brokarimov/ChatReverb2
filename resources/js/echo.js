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
        const messageCount = document.getElementById('messageCount'); // Assume you have a span with this ID for counting

        // Get the current count of messages
        let currentCount = parseInt(messageCount.textContent) || 0;

        // Increment the message count
        currentCount++;

        // Update the message count display
        messageCount.textContent = currentCount;

        // Create a new list item
        const newMessage = document.createElement('li');

        // Create the anchor element
        const newAnchor = document.createElement('a');
        newAnchor.classList.add('dropdown-item');
        newAnchor.href = `/read/${e.message.id}`;

        // Create a div container for the image and text
        const messageContent = document.createElement('div');
        messageContent.classList.add('d-flex');

        // Create and set the image
        const newImage = document.createElement('img');
        newImage.src = e.message.image;
        newImage.width = 100;
        newImage.alt = "Message Image";

        // Create the text node
        const messageText = document.createTextNode(e.message.text);

        // Append the image and text to the container div
        messageContent.appendChild(newImage);
        messageContent.appendChild(messageText);

        // Append the container div to the anchor
        newAnchor.appendChild(messageContent);

        // Append the anchor to the list item
        newMessage.appendChild(newAnchor);

        // Prepend the new list item to the message list
        messageList.prepend(newMessage);
    });
