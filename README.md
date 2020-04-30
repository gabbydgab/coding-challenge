# Coding Challenge: Event Scheduling

The goal for this particular challenge is to schedule an event on your calendar - see [exam](http://178.128.212.62/) requirements.

See live demo at [https://challenge.codingmatters.today](https://challenge.codingmatters.today)

Following are the features needed to be developed:

### Scheduling of Event
Following events are repetitive in nature, based on the period given (start and end date) 
- [x] Set an event on weekdays
- [x] Set an event on weekends
- [x] Set a month-long event

Following schedule is for ONCE only - given that the start and end date is the same day since we are not using time.
- [x] Schedule for payroll

#### Overriding Schedule
Since there's no time associated with the event, if the newly saved event will override the schedule 
- [x] Updating gym appointment to eating
PS: This feature is base on the exam video. 

### Updating Event
To be discussed

### Deleting Event
To be discussed

## Libraries and Frameworks
- [FullCalendar Vue Component](https://fullcalendar.io/docs/vue) - for the calendar component where you can show the schedule of events
- [Vue.js](https://vuejs.org/v2/guide/) - for the front-end
- [Vuejs-Snackbar](https://github.com/livelybone/vuejs-snackbar) - component for the notifications
- [Bootstrap](https://getbootstrap.com/) - for UI templating
- [Laravel 7.x](https://laravel.com/docs) - for the backend
