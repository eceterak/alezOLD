<div class="d-flex justify-content-between">
    <span>
        <a href="{{ route('profiles.show', $activity->user->id) }}">{{ $activity->user->name }}</a> 
        dodał nowe ogłoszenie <a href="{{ route('admin.adverts.edit', $activity->subject->slug) }}">{{ str_limit($activity->subject->title, 40) }}</a>
    </span>
    <small>{{ $activity->created_at->diffForHumans() }}</small>
</div>