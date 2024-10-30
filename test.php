
 <!DOCTYPE html>
 <html>
   <head>
     <title>Botpress in a div</title>
     <meta name="viewport" content="width=device-width, initial-scale=1" />
  
     <style>
       body {
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         margin: 0;
         color: white;
         background-color: #000000;
         font-family: Arial, sans-serif;
       }
  
       .center-div {
         width: 50vw;
         height: 80vh;
         background-color: rgb(102, 71, 255);
         border-radius: 15px;
         padding: 5px;
         box-sizing: border-box;
         color: white;
         display: flex;
         justify-content: center;
         align-items: center;
         text-align: center;
       }
  
       @media only screen and (max-width: 600px) {
         .center-div {
           height: 40vh;
           width: 80vw;
           background-color: rgb(102, 71, 255);
           border-radius: 15px;
           padding: 5px;
           box-sizing: border-box;
           color: white;
           display: flex;
           justify-content: center;
           align-items: center;
           text-align: center;
         }
       }
     </style>
   </head>
  
   <body>
     <div>
       <p style="text-align: center;">Botpress Chatbot in a <span><</span><span>div></span></p>
       <div class="absolute inset-4 ">
         <div
           class="center-div relative h-full w-full overflow-clip rounded-md border border-zinc-200 bg-white p-2 px-0 py-0"
         >
           <iframe
             style="border: none;"
             srcdoc="<body><script src='https://cdn.botpress.cloud/webchat/v0/inject.js'></script>
             <script>
               window.botpressWebChat.init({
                   'composerPlaceholder': 'Chat with Azure bot',
                   'botConversationDescription': 'Khám phá Azure Resort',
                   'botName': 'Azure bot',
                   'botId': '326647f2-a16f-41d2-becb-8edf7c6fdbcd',
                   'hostUrl': 'https://cdn.botpress.cloud/webchat/v0',
                   'messagingUrl': 'https://messaging.botpress.cloud',
                   'clientId': '326647f2-a16f-41d2-becb-8edf7c6fdbcd',
                   'enableConversationDeletion': true,
                   'showPoweredBy': true,
                   'className': 'webchatIframe',
                   'containerWidth': '100%25',
                   'layoutWidth': '100%25',
                   'hideWidget': true,
                   'showCloseButton': false,
                   'disableAnimations': true,
                   'closeOnEscape': false,
                   'showConversationsButton': false,
                   'enableTranscriptDownload': false,
                   'stylesheet':'https://webchat-styler-css.botpress.app/prod/b93a3edb-4d8f-48a0-a4fa-d1098729ad48/v48838/style.css'
                   
               });
             window.botpressWebChat.onEvent(function () { window.botpressWebChat.sendEvent({ type: 'show' }) }, ['LIFECYCLE.LOADED']);
             </script></body>"
             width="100%"
             height="100%"
           ></iframe>
         </div>
       </div>
     </div>
     <script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>
<script src="https://mediafiles.botpress.cloud/326647f2-a16f-41d2-becb-8edf7c6fdbcd/webchat/config.js" defer></script>
   </body>
 </html>