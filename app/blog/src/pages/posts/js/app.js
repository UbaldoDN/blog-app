async function loadPosts() {
    try {
        const response = await fetch('http://localhost/api/v1/posts');
        const posts = await response.json();
        const postsContainer = document.getElementById('posts');
        postsContainer.innerHTML = '';
        posts.data.forEach(post => {
            const postElement = document.createElement('div');
            postElement.classList.add('bg-white', 'p-6', 'rounded-lg', 'mb-6', 'shadow-md', 'hover:shadow-lg', 'transition-shadow', 'duration-200');

            const postTitle = document.createElement('h3');
            postTitle.classList.add('text-xl', 'font-semibold', 'mb-2');
            postTitle.textContent = post.title;

            const postBody = document.createElement('p');
            postBody.classList.add('text-gray-700', 'mb-4');
            postBody.textContent = post.body;

            const postLink = document.createElement('a');
            postLink.classList.add('text-blue-500', 'hover:underline');
            postLink.href = `detail.html?postId=${post.id}`;
            postLink.textContent = 'Read more';

            postElement.appendChild(postTitle);
            postElement.appendChild(postBody);
            postElement.appendChild(postLink);

            postsContainer.appendChild(postElement);
        });
    } catch (error) {
        console.error('Error loading posts:', error);
    }
}

async function detailPost() {
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('postId');

    try {
        const response = await fetch(`http://localhost/api/v1/posts/${postId}`);
        const post = await response.json();

        const postContainer = document.getElementById('post');
        postContainer.innerHTML = '';

        const postElement = document.createElement('div');
        postElement.classList.add('bg-white', 'p-6', 'rounded-lg', 'shadow-md', 'hover:shadow-lg', 'transition-shadow', 'duration-200');

        const postTitle = document.createElement('h3');
        postTitle.classList.add('text-2xl', 'font-semibold', 'mb-4');
        postTitle.textContent = post.data.title;

        const postBody = document.createElement('p');
        postBody.classList.add('text-gray-700');
        postBody.textContent = post.data.body;

        const divider = document.createElement('hr');
        divider.classList.add('border-t', 'border-gray-300', 'my-4');

        const postAuthorContainer = document.createElement('div');
        postAuthorContainer.classList.add('flex', 'space-x-4', 'text-gray-600', 'mt-4');

        const postAuthorId = document.createElement('p');
        postAuthorId.textContent = `Author ID: ${post.data.author.id}`;

        const postAuthor = document.createElement('p');
        postAuthor.textContent = `Author: ${post.data.author.name}`;

        const postEmail = document.createElement('p');
        postEmail.textContent = `Email: ${post.data.author.email}`;

        postAuthorContainer.appendChild(postAuthorId);
        postAuthorContainer.appendChild(postAuthor);
        postAuthorContainer.appendChild(postEmail);

        postElement.appendChild(postTitle);
        postElement.appendChild(postBody);
        postElement.appendChild(divider);
        postElement.appendChild(postAuthorContainer);
        postContainer.appendChild(postElement);
    } catch (error) {
        console.error('Error loading post:', error);
    }
}

document.addEventListener('DOMContentLoaded', detailPost);
document.addEventListener('DOMContentLoaded', loadPosts);