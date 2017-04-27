Array.from(document.querySelectorAll('.load-form-btn'))
	.forEach(btn => btn.addEventListener('click', e => {
		console.log(e.currentTarget.dataset.formurl);
		fetch(e.currentTarget.dataset.formurl, {
			headers: new Headers({
				'Accept': 'text/html'
			})
		})
		.then(response => response.text())
		.then(response => {
			document.querySelector('.action-form').innerHTML = response;
		})
	}));

document.querySelector('form.action-form').addEventListener('submit', e => {
	e.preventDefault();
});