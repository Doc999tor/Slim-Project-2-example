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
		if (url.includes('edit') || url.includes('add')) {
			var formHandler = new FormHandler(container.querySelector('form'));
			container.querySelector('form').addEventListener('submit', e => {
				e.preventDefault();
				formHandler.url = url.match(/\w+/g);
				if (!formHandler.isPristine()) {
					formHandler.send().then(() => {/*location.reload();*/});
				} else {console.log('form has not changed');}
			});
			var deleteBtn = container.querySelector('.delete-btn');
			if (deleteBtn) {
				deleteBtn.addEventListener('click', e => {
					formHandler.url = e.currentTarget.dataset.formurl.match(/\w+/g);
					formHandler.delete();
				});
			}
		} else {
			attachLoadEvent(Array.from(container.querySelectorAll('.load-form-btn')))
		}
	})
}