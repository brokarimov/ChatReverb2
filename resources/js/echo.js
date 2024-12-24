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

console.log(chatID)

window.Echo.channel(`message.${chatID}`)
    .listen('MessageEvent', (e) => {
        console.log(e);
        if (e.message.sender_id != userID) {
            const messageList = document.getElementById('messageList');
            const newMessage = document.createElement('li');

            if (e.message.image) {
                if (e.message.file_type === 'image') {
                    // Create an image element for file_type 'image'
                    const newImage = document.createElement('img');
                    newImage.src = `${window.location.origin}/${e.message.image}`;
                    newImage.width = 100;
                    messageList.prepend(newImage);

                } else if (e.message.file_type === 'video') {
                    // Create a video element for file_type 'video'
                    const newVideo = document.createElement('video');
                    newVideo.src = `${window.location.origin}/${e.message.image}`;
                    newVideo.width = 100; // Set video width
                    newVideo.controls = true; // Add controls to the video
                    messageList.prepend(newVideo);

                } else if (e.message.file_type === 'file') {
                    // Create a link element for file_type 'file'
                    const newFileLink = document.createElement('a');
                    newFileLink.href = `${window.location.origin}/${e.message.image}`;
                    newFileLink.target = '_blank'; // Open in a new tab
                    newFileLink.innerText = 'View file';
                    messageList.prepend(newFileLink);
                }
            }




            let senderName = '';
            usersAll.forEach(user => {
                if (e.message.sender_id === user.id) {
                    senderName = user.name;
                }
            });
            newMessage.innerHTML = `<span class="text-danger">${senderName}</span>: ${e.message.text}`;


            messageList.prepend(newMessage);
        }

    })
    .error((error) => {
        console.error('Error in receiving the event: ', error);
    });

window.Echo.channel('user')
    .listen('UserEvent', (e) => {
        console.log(e);
        const userList = document.getElementById('userList');
        const newUser = document.createElement('li');

        const newAnchor = document.createElement('a');
        newAnchor.href = `/message/${e.user.id}`;
        const username = document.createTextNode(e.user.name);
        newAnchor.appendChild(username);

        newUser.appendChild(newAnchor);


        userList.prepend(newUser);
    });


// window.Echo.channel('message')
//     .listen('MessageEvent', (e) => {
//         console.log(e);

//         const messageList = document.getElementById('messageList');
//         const messageCount = document.getElementById('messageCount');


//         let currentCount = parseInt(messageCount.textContent) || 0;


//         currentCount++;


//         messageCount.textContent = currentCount;


//         const newMessage = document.createElement('li');


//         const newAnchor = document.createElement('a');
//         newAnchor.classList.add('dropdown-item');
//         newAnchor.href = `/read/${e.message.id}`;


//         const messageContent = document.createElement('div');
//         messageContent.classList.add('d-flex');


//         const newImage = document.createElement('img');
//         newImage.src = e.message.image;
//         newImage.width = 100;
//         newImage.alt = "Message Image";


//         const messageText = document.createTextNode(e.message.text);


//         messageContent.appendChild(newImage);
//         messageContent.appendChild(messageText);


//         newAnchor.appendChild(messageContent);


//         newMessage.appendChild(newAnchor);


//         messageList.prepend(newMessage);
//     });
