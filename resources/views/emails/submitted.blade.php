<h2>Nieuwe inzending voor challenge: {{ $submitted->challenge->title }}</h2>

<p>{{ $submitted->challenge->description }}</p>


Challenge foto:
<a href="{{ url($submitted->challenge->image_path) }}"> Klik hier</a>

<br>
Gestuurde foto:
<a href="{{ url($submitted->content) }}"> Klik hier</a>

<br>
<br>
<br>
<a href="{{ route('submission.approve', ['id' => $submitted->id, 'token' => $submitted->token]) }}"
   style="padding:12px 20px;background:#4CAF50;color:white;text-decoration:none;border-radius:6px;">
    ✔️ Accepteren
</a>

<a href="{{ route('submission.reject', ['id' => $submitted->id, 'token' => $submitted->token]) }}"
   style="padding:12px 20px;background:#E53935;color:white;text-decoration:none;border-radius:6px; margin-left:10px;">
    ❌ Afwijzen
</a>
