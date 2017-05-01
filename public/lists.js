attachLoadEvent(Array.from(document.querySelectorAll('.load-form-btn')));
// document.querySelectorAll('.load-form-btn')[5].click();
loadTemplate('courses/addForm');

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
			container.querySelector('form').addEventListener('submit', e => {
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

var FormFactory = function (action) {
	switch (action) {
		case 'add':    return function (entity) {
			console.log(`${entity}/add/post`);
		}
		case 'edit':   return function (entity, id) {
			console.log(`${entity}/edit/${id}/put`);
		}
		case 'delete': return function (entity, id) {
			console.log(`${entity}/delete/${id}/put`);
		}
		default: console.log(action); break;
	}
}

var addEntity    = FormFactory('add');
var editEntity   = FormFactory('edit');
var deleteEntity = FormFactory('delete');
var form = document.querySelector('.main-container');