export const app = app_name;

export const whatsapp = app_whatsapp;

export const nick = app_nick;

export const url = (path = '') => {
	return app_url + '/' + path;
}

export const asset = (path = '') => {
	return app_asset + path;
}

export const userID = () => {
	return app_user_id;
}

export const http = {
	get: function(location) {
		return fetch(url(location), {
			method: 'GET'
		}).then(res => res.json());
	},
	post: function(location, body) {
		return fetch(url(location), {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json'
			},
			body: JSON.stringify(body)
		}).then(res => res.json());
	},
	put: function(location, body) {
		return fetch(url(location), {
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json'
			},
			body: JSON.stringify(body)
		}).then(res => res.json());
	},
	delete: function(location) {
		return fetch(url(location), {
			method: 'DELETE'
		}).then(res => res.json());
	}
}

export const read = (file, callback) => {
	const reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = () => {
		return callback(reader.result);
	}
}


export const modal = {
	open: function(selector) {
		var el = document.querySelector(selector);
		var modal = new bootstrap.Modal(el);
		modal.show();	
	},
	close: function() {
		document.querySelectorAll('.modal.fade.show').forEach(obj => {
			obj.style.display = 'none';
			const modal = new bootstrap.Modal(obj);
			modal.hide();
		});

		document.body.classList.remove('modal-open');
		document.querySelectorAll('.modal-backdrop').forEach(obj => {
			obj.remove();
		})
		document.body.style.padding = '0';
		document.body.style.margin = '0';
	}
}

export const user = () => {
	return http.get('api/user/' + userID());
}

export const readQueryString = (queryString) => {
	var array = {};
	queryString.slice(1).split('&').forEach(obj => {
		const data = obj.split('=');
		array[decodeURIComponent(data[0])] = decodeURIComponent(data[1]);
	});

	return array;
}

export const blank = (url) => {
	const a = document.createElement('A');
	a.href = url;
	a.target = '_blank';
	a.click();
	a.remove();
}

export const getWhatsapp = () => {
	return http.get('api/setting');
}