attachLoadEvent(Array.from(document.querySelectorAll('.load-form-btn')));
// document.querySelectorAll('.load-form-btn')[5].click();
loadTemplate('admins/edit/1');

function attachLoadEvent(btns) {
	btns.forEach(btn => btn.addEventListener('click', e => {
		console.log(e.currentTarget.dataset.formurl);
		loadTemplate(e.currentTarget.dataset.formurl);
	}));
}

function loadTemplate(url) {
	fetch(url, {
		headers: new Headers({
			'Accept': 'text/html'
		})
	})
	.then(response => response.text())
	.then(response => {
		const container = document.querySelector('section.main-container');
		container.innerHTML = response;
		if (url.includes('edit')) {
			container.querySelector('form.edit').addEventListener('submit', e => {
				e.preventDefault();
				handleForm(...url.match(/\w+/g));
			});
			container.querySelector('.delete-btn').addEventListener('click', e => {
				handleForm(...e.currentTarget.dataset.formurl.match(/\w+/g));
			});
		} else {
			attachLoadEvent(Array.from(container.querySelectorAll('.load-form-btn')))
		}
	})
}

function handleForm(entity, action, id) {
	console.log(arguments);
}