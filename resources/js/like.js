// resources/js/like.js

document.addEventListener('DOMContentLoaded', function() {
    const likeBtns = document.querySelectorAll('.like-btn');
    likeBtns.forEach(likeBtn => {
        likeBtn.addEventListener('click', async (e) => {
            const clickedEl = e.target;
            clickedEl.classList.toggle('liked');
            const postId = e.target.id;
            const postType = e.target.getAttribute('data-post-type');
            const res = await fetch('/post/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ post_id: postId, post_type: postType })
            })
            .then((res) => res.json())
            .then((data) => {
                clickedEl.nextElementSibling.innerHTML = data.likesCount;
            })
            .catch(() => alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。'));
        });
    });
});
