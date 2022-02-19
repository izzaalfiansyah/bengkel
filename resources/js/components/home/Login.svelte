<script>
    import { url, http, userID } from '../../app';
    import Section from './Section.svelte';

    // data
    let username;
    let password;

    // function
    let login = (e) => {
        e.preventDefault();
        http.post('api/user/login', {
            username: username,
            password: password
        }).then(res => {
            if (res.error) {
                notif(res.message, 'warning', true);
            } else {
                notif(res.message, 'success');
                setTimeout(() => {
                    window.location = url('login/' + res.data.id + '/' + res.data.level);
                }, 1000);
            }
        })
    }

    if (userID()) {
        window.location = url('admin');
    }
</script>
<Section title="Login">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="p-4 bg-white shadow-sm">
                <form on:submit={login}>
                    <p class="text-center">Masukkan data anda!</p>
                    <hr>

                    <label for="">Username</label>
                    <input type="text" bind:value={username} class="form-control" placeholder="Masukkan Username" required="true">

                    <label for="">Password</label>
                    <input type="password" bind:value={password} class="form-control" placeholder="Masukkan Password" required="true">

                    <div class="mt-4">
                        <button class="btn btn-block btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</Section>