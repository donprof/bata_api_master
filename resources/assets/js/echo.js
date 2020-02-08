import Bus from './bus'
// Echo.join('online')
// .here(users => (this.users = users))
// .joining(user => this.users.push(user))
// .leaving(user => (this.users = this.users.filter(u => (u.id !== user.id))))

// import localforage from 'localforage'
// Echo.private('App.User.2')
// .notification('themechanged', (data) => {
// 	console.log(data)
// });



Echo.join('callbacks')
	.here((users) => {
		Bus.$emit('fleetUsers.loggedin', users)
	})
	.joining((users) => {
		Bus.$emit('fleetUsers.joined', users)
	})
	.leaving((users) => {
		Bus.$emit('fleetUsers.left', users)
	})
	.listen('Pusher.UserEvent', (message) => {
        console.log(message)
		// Bus.$emit('message.recieved', message)
    })
    .listen('my-event', (data) => {
        console.log(data)
		// Bus.$emit('message.recieved', message)
    });

// Echo.channel('users.1')
//     .listen('theme-changed', (e) => {
//         console.log(e);
//     });

// Echo.private('users.1')
//     .listen('theme-changed', (e) => {
//         console.log(e);
//     });