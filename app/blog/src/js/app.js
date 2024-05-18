document.addEventListener('DOMContentLoaded', function () {
    const postsMenu = document.getElementById('postsMenu');
    const authorMenu = document.getElementById('authorMenu');
    const adminMenu = document.getElementById('adminMenu');
    
    postsMenu.addEventListener('click', showPostsSection);
    authorMenu.addEventListener('click', showAuthorSection);
    adminMenu.addEventListener('click', showAdminSection);
  
    setupAuthorPage();
    setupAdminPage();
    loadPosts();
  });
  
  function showPostsSection() {
    document.getElementById('postsSection').classList.remove('hidden');
    document.getElementById('authorSection').classList.add('hidden');
    document.getElementById('adminSection').classList.add('hidden');
  }
  
  function showAuthorSection() {
    document.getElementById('postsSection').classList.add('hidden');
    document.getElementById('authorSection').classList.remove('hidden');
    document.getElementById('adminSection').classList.add('hidden');
  }
  
  function showAdminSection() {
    document.getElementById('postsSection').classList.add('hidden');
    document.getElementById('authorSection').classList.add('hidden');
    document.getElementById('adminSection').classList.remove('hidden');
  }
  
  function setupAuthorPage() {
    const loginButton = document.getElementById('authorLoginButton');
    const logoutButton = document.getElementById('authorLogoutButton');
    const createPostButton = document.getElementById('createPostButton');
  
    loginButton.addEventListener('click', authorLogin);
    logoutButton.addEventListener('click', authorLogout);
    createPostButton.addEventListener('click', createPost);
  }
  
  function setupAdminPage() {
    const loginButton = document.getElementById('adminLoginButton');
    const logoutButton = document.getElementById('adminLogoutButton');
    const approvePostButton = document.getElementById('approvePostButton');
  
    loginButton.addEventListener('click', adminLogin);
    logoutButton.addEventListener('click', adminLogout);
    approvePostButton.addEventListener('click', approvePost);
  }
  
  async function authorLogin() {
    const email = document.getElementById('authorEmail').value;
    const password = document.getElementById('authorPassword').value;
    try {
      const response = await fetch('http://localhost/api/v1/authors/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });
      const data = await response.json();
      console.log('Author login successful:', data);
    } catch (error) {
      console.error('Error logging in as author:', error);
    }
  }
  
  async function authorLogout() {
    try {
      const response = await fetch('http://localhost/api/v1/authors/logout', {
        method: 'POST',
      });
      console.log('Author logout successful:', response);
    } catch (error) {
      console.error('Error logging out as author:', error);
    }
  }
  
  async function createPost() {
    const title = document.getElementById('postTitle').value;
    const body = document.getElementById('postBody').value;
    try {
      const response = await fetch('http://localhost/api/v1/authors/posts', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ title, body }),
      });
      const data = await response.json();
      console.log('Post created:', data);
    } catch (error) {
      console.error('Error creating post:', error);
    }
  }
  
  async function adminLogin() {
    const email = document.getElementById('adminEmail').value;
    const password = document.getElementById('adminPassword').value;
    try {
      const response = await fetch('http://localhost/api/v1/admin/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password }),
      });
      const data = await response.json();
      console.log('Admin login successful:', data);
    } catch (error) {
      console.error('Error logging in as admin:', error);
    }
  }
  
  async function adminLogout() {
    try {
      const response = await fetch('http://localhost/api/v1/admin/logout', {
        method: 'POST',
      });
      console.log('Admin logout successful:', response);
    } catch (error) {
      console.error('Error logging out as admin:', error);
    }
  }
  
  async function approvePost() {
    const postId = document.getElementById('postIdToApprove').value;
    try {
      const response = await fetch(`http://localhost/api/v1/admin/posts/${postId}/approve`, {
        method: 'PATCH',
      });
      console.log('Post approved:', response);
    } catch (error) {
      console.error('Error approving post:', error);
    }
  }
  
  async function loadPosts() {
    try {
        const response = await fetch('http://localhost/api/v1/posts');
        const posts = await response.json();
        const postsContainer = document.getElementById('posts');
        postsContainer.innerHTML = '';
        console.log(posts);
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
            postLink.href = `/post-detail.html?postId=${post.id}`;
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