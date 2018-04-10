<template>
    <ul>
        <li v-for="message in messages">{{ message.body }}</li>
    </ul>
</template>

<script>
    export default {
      data() {
        return {
          messages: [
            { body: 'Missatge 1'},
            { body: 'Missatge 2'},
            { body: 'Missatge 3'}
          ]
        }
      },
      mounted() {
        Echo.channel('new-message')
          .listen('ChatMessage', (event) => {
            console.log('He rebut un nou event de broadcast')
            console.log(event)

            this.messages.push({body:event.message})

          });
      }
    }
</script>
