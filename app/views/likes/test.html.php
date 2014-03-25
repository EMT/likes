
<h1>Like Test</h1>

<div>
    <a href="#" data-like-action="yada">Like</a>
    <p>Likes: <span data-like-count="yada"></span></p>
</div>

<div>
    <a href="#" data-like-action="yada2">Like</a>
    <p>Likes: <span data-like-count="yada2"></span></p>
</div>

<div>
    <a href="#" data-like-action="yada3">Like</a>
    <p>Likes: <span data-like-count="yada3"></span></p>
</div>


<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
$(function() {
    // populate like counts on the page
    var likeIds = {
        user: 'test',
        namespace: 'ns',
        key: []
    };
    $('[data-like-count]').each(function() {
        likeIds.key.push($(this).data('likeCount'));
    });

    if (likeIds.key.length) {
        $.ajax({
            url: 'http://likes.fieldwork.dev/likes/get.json', 
            data: likeIds,
            success: function(data) {
                if (data && data.count) {
                    for (var i = 0, len = data.count.length; i < len; i ++) {
                        $('[data-like-count=' + data.count[i].k.split('.')[2] + ']').text(data.count[i].count);
                    }
                }
            },
            dataType: 'json'
        });
    }

    // Post like on click and update count on success
    $('[data-like-action]').on('click', function(e) {
        e.preventDefault();
        $.post(
            'http://likes.fieldwork.dev/likes/add.json', 
            {
                user: likeIds.user,
                namespace: likeIds.namespace,
                key: $(this).data('likeAction')
            },
            function(data) {
                if (data && data.like && data.like.id) {
                    var selector = '[data-like-count=' + data.like.key + ']',
                        count = $(selector).text() || 0;

                console.log(count);
                console.log(count + 1);
                    $(selector).text(count + 1);
                }
            },
            'json'
        );
    });
});
</script>