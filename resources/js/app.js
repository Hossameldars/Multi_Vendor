import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

var channel = Echo.private('App.Models.User.{{ auth()->id() }}');

channel.notification( function(data) {
    alert(JSON.stringify(data));
});