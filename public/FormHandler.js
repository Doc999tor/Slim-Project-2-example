class FormHandler {
	constructor (form) {
		console.log(form);
		this.form = form;
		this.previousState = this.saveState();
		console.log(this.previousState);
		this.form.addEventListener('change', this.updateImagePreview.bind(this));
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
		this.currentState = this.saveState();
		return JSON.stringify(this.previousState) === JSON.stringify(this.currentState);
	}

	get formData () {
		var formData  = new FormData(this.form);
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

	updateImagePreview () {
		var input = this.form.querySelector('input[type=file]');

		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = e => {
				var preview = this.form.querySelector('input[type=file]+img');
				preview.src = e.target.result;
			}

			reader.readAsDataURL(input.files[0]);
		}


	}
}