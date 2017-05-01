class FormHandler {
	constructor (form) {
		console.log(form);
		this.form = form;
		this.previousState = this.saveState();
		console.log(this.previousState);
	}

	send () {
		console.log(this.entity);
		console.log(this.action);
		console.log(this.id);
		console.log(this.url);
		return fetch(this.url, {
			method: this.requestMethod,
			headers: new Headers({
				'Accept': 'text/html',
			}),
			body: this.formData,
		})
		.then(response => {
			if (response.status > 299) {throw new Error(`${response.status}: ${response.statusText}`);}
			console.log(response);return response.text()
		})
		.then(response => {console.log(response);return response;})
		.catch(e => console.log(e.message))
	}

	saveState () {
		var data = Array.from(this.form.querySelectorAll('input,select'))
			.reduce((obj, input) => {obj[input.name] = input.value; return obj;}, {})
		data[this.form.querySelector('textarea').name] = this.form.querySelector('textarea').textContent;
		return data;
	}

	isPristine () {
		if (!this.currentState) {this.currentState = this.saveState();}
		return JSON.stringify(this.previousState) === JSON.stringify(this.currentState);
	}

	get formData () {
		if (!this.currentState) {this.currentState = this.saveState();}
		var formData  = new FormData(this.form);
		// Object.keys(this.currentState).forEach(k => {
		// 	formData.append(k, this.currentState[k]);
		// });
		return formData;
	}

	get url () {
		return `${this.entity}` + (this.id ? `/${this.id}` : '');
	}
	set url (urlComponents) {
		[this.entity, this.action, this.id = null] = urlComponents;
	}

	get requestMethod () {
		var method = '';
		switch (this.action) {
			case 'edit': method = 'POST'; break;
			case 'add' : method = 'POST'; break; // PHP doesn't support for sending form data put requests. Just use post.
			case 'delete': method = 'DELETE'; break;
			default: console.log('unknown request method'); break;
		}
		return method;
	}
}