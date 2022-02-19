import Home from './layouts/Home.svelte';

let app = new Home({
	target: document.getElementById('app')
});

export default app;