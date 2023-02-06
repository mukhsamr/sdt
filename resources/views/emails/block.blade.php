<body style="font-family: 'Roboto'; background-color: rgb(241 245 249);">
    <div id="container" style="height: 100%; margin-left: 10%;">
        <div id="card"
            style="padding: 24px; border-radius: 8px; background-color: white; width: 80%; height: fit-content; margin-top: 96px;">
            <span id="title" style="font-size: 24px; line-height: 32px; font-weight: 600; color: #3b82f6;">
                SD Track
            </span>
            <div id="comment" style="font-size: 14px; line-height: 20px; color: rgb(148 163 184);">Santri Device
                Tracking</div>

            <hr style="margin-top: 8px; margin-bottom: 8px;">

            <div style="margin-top: 8px;">
                <span id="blokir" style="font-size: 20px; line-height: 28px; color: rgb(51 65 85);">
                    Santri Diblokir
                </span>

                <div style="font-size: 14px;line-height: 20px; color: rgb(71 85 105);">{{$tanggal}}</div>

                <ul id="list" style="margin-top: 16px; list-style-type: disc;">
                    @foreach ($siswa as $item)
                    <li>{{$item}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</body>