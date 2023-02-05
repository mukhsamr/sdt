<body>
    <div id="container">
        <div id="card">
            <span id="title">
                SD Track
            </span>
            <div id="comment">Santri Device Tracking</div>

            <hr style="margin-top: 1rem; margin-bottom: 1rem;">

            <div style="margin-top: 1rem;">
                <span id="blokir">
                    Santri Diblokir
                </span>

                <div style="font-size: 0.875rem;line-height: 1.25rem; color: rgb(71 85 105);">{{$tanggal}}</div>

                <ul id="list">
                    @foreach ($siswa as $item)
                    <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</body>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    body {
        font-family: 'Poppins';
        background-color: rgb(241 245 249);
    }

    #container {
        display: flex;
        justify-content: center;
        height: 100%;
        width: 100%;
    }

    #card {
        display: block;
        padding: 1.5rem;
        border-radius: 0.5rem;
        background-color: white;
        width: 50%;
        height: fit-content;
        margin-top: 6rem;
    }

    #title {
        font-size: 1.5rem;
        line-height: 2rem;
        font-weight: 600;
        color: #3b82f6;
    }

    #comment {
        font-size: 0.875rem;
        line-height: 1.25rem;
        color: rgb(148 163 184);
    }

    #blokir {
        font-size: 1.25rem;
        line-height: 1.75rem;
        color: rgb(51 65 85);
    }

    #list {
        margin-top: 1rem;
        list-style-type: disc;
    }
</style>