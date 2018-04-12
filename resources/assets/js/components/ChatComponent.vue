<template>
    <div>
        <ul>
            <li v-for="message in messages">{{ message.body }} </li>
        </ul>
        <input type="text" v-model="newMessage" @keydown="tapParticipants">
        <button @click="send">Enviar</button>
        <span v-if="activePeer">User {{ activePeer.name}} is typing...</span>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        activePeer: false,
        newMessage: '',
        messages: [
          { body: 'Missatge 1'},
          { body: 'Missatge 2'},
          { body: 'Missatge 3'}
        ]
      }
    },
    methods: {
      tapParticipants() {
        Echo.private('new-message')
          .whisper('typing', {
            name: user.name
          });
      },
      send() {
        axios.post('/chat_message',{
          'body': this.newMessage
        })
      }
    },
    mounted() {
      console.log('Component mounted.')
      Echo.private('new-message')
        .listen('ChatMessage', (event) => {
          console.log('He rebut un nou event de broadcast')
          console.log(event);

          this.messages.push({ body: event.message})

        })
        .listenForWhisper('typing', (e) => {
          console.log(e.name);
          this.activePeer = {}
          this.activePeer.name = e.name
          setTimeout(() => {
            this.activePeer = false
          }, 1000);

        });
    }
  }
</script>