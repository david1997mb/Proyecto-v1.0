<script>
import { defineComponent } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import esLocale from '@fullcalendar/core/locales/es';

export default defineComponent({
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
          interactionPlugin
        ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: esLocale,
        initialView: 'dayGridMonth',
        selectable: true,
        selectMirror: true,
        dayMaxEvents: true,
        weekends: true,
        allDaySlot: false,
        slotMinTime: '13:00:00',
        slotMaxTime: '24:00:00'

      },
      events: [],
    }
  },
  created() {
    this.fetchEvents();
  },
  methods: {
  async fetchEvents() {
    try {
      const response = await axios.get('/api/eventsall');
      const reservas = response.data;
      const eventos = reservas.map(reserva => {
        return {
          title: ` Tipo Evento: ${reserva.type}  - | Cliente: ${reserva.client} -  Invitados: ${reserva.guests}| - | Estado Pago: ${reserva.status} | - |Costo: ${reserva.cost} Bs.| - | Saldo: ${reserva.saldo} Bs.`,
          start: `${reserva.event_date}T14:00:00`, 
          end: `${reserva.event_date}T23:59:00`, 
          guests: reserva.guests,
          cost: reserva.cost,
        };
      });
      this.calendarOptions.events = eventos;
    } catch (error) {
      console.error('Error Listar Eventos:', error);
    }
  },
},

})
</script>

<template>
  <div class='demo-app'>
    <div class='demo-app-main'>
      <FullCalendar class='demo-app-calendar' :options='calendarOptions'>
        <template v-slot:eventosContent="arg">
          <b>{{ arg.timeText }}</b>
          <i>Tipo: {{ arg.title }}</i>
          <br>
             {{ arg.guests }}- {{ arg.cost }}
        </template>
      </FullCalendar>
    </div>
  </div>
</template>

<style lang='css'>
h2 {
  margin: 0;
  font-size: 16px;
}

ul {
  margin: 0;
  padding: 0 0 0 1.5em;
}

li {
  margin: 1.5em 0;
  padding: 0;
}

b {
  /* used for event dates/times */
  margin-right: 3px;
}

.demo-app {
  display: flex;
  min-height: 100%;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
  background: #eaf9ff;
  border-right: 1px solid #d3e2e8;
}

.demo-app-main {
  flex-grow: 1;
  padding: 3em;
}

.fc {
  /* the calendar root */
  max-width: 1100px;
  margin: 0 auto;
}
</style>
