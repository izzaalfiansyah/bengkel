import Admin from './layouts/Admin.svelte';

let app = new Admin({
	target: document.getElementById('app')
});

export default app;