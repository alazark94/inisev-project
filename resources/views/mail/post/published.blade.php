<x-mail::message>
# New Post Published

{{$post->title}}

<x-mail::button :url="$url">
View Post
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
