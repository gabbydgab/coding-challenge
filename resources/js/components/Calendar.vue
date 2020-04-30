<template>
    <div class="row">
        <snackbar id="snackbar" baseSize="100px" ref="snackbar" :holdTime="2000" :position="position" :multiple="true"/>
        <div class="col-md-5">
            <h1>Calendar</h1>
            <div class="form-group">
                <label for="title">Event</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Event title" v-model="event.title">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="date" v-model="event.start_date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end" v-model="event.end_date">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="mon" name="mon" value="true" v-model="event.mon">
                    <label class="form-check-label" for="mon">Mon</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="tue" name="tue" value="true" v-model="event.tue">
                    <label class="form-check-label" for="tue">Tue</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="wed" name="wed" value="true" v-model="event.wed">
                    <label class="form-check-label" for="wed">Wed</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="thu" name="thu" value="true" v-model="event.thu">
                    <label class="form-check-label" for="thu">Thu</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="fri" name="fri" value="true" v-model="event.fri">
                    <label class="form-check-label" for="fri">Fri</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="sat" name="sat" value="true" v-model="event.sat">
                    <label class="form-check-label" for="sat">Sat</label>
                </div>
                <div class="divider">&nbsp;&nbsp;&nbsp;</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="sun" name="sun" value="true" v-model="event.sun">
                    <label class="form-check-label" for="sun">Sun</label>
                </div>
            </div>
            <button @click="saveEvent()" class="btn btn-primary" id="save">Save</button>
        </div>
        <div class="col-md-7">
            <full-calendar defaultView="dayGridMonth" :plugins="calendarPlugins" :events="events"/>
        </div>
    </div>
</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import Snackbar from 'vuejs-snackbar';

    export default {
        name: "Calendar",
        components: {
            FullCalendar,
            Snackbar,
        },
        created() {
            this.getEvents();
        },
        data() {
            return {
                position: 'top-right',
                calendarPlugins: [ dayGridPlugin ],
                events: [],
                event: {
                    title: "",
                    start_date: "",
                    end_date: "",
                    mon: "",
                    tue: "",
                    wed: "",
                    thu: "",
                    fri: "",
                    sat: "",
                    sun: ""
                },
            }
        },
        methods: {
            getEvents() {
                fetch('/api/events', {method: "GET"})
                .then(response => response.json())
                .then(response => {
                    this.events = response.data;
                })
                .catch(error => {
                    this.$refs.snackbar.warn('Cannot fetch events');
                })
            },

            saveEvent() {
                axios({
                   method: "POST",
                    url: "/api/events",
                   headers: {
                       "content-type": "application/json"
                   },
                    data: this.event
                })
                .then(response => {
                    this.resetForm();
                    this.$refs.snackbar.info(response.data.message);
                    this.getEvents();
                })
                .catch(error => {
                    this.$refs.snackbar.warn("Cannot save event");
                });
            },

            resetForm() {
                this.event.title = "";
                this.event.start_date = "";
                this.event.end_date = "";
                this.event.mon = "";
                this.event.tue = "";
                this.event.wed = "";
                this.event.thu = "";
                this.event.fri = "";
                this.event.sat = "";
                this.event.sun = "";
            }
        }
    }
</script>

<style scoped>
    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
</style>
