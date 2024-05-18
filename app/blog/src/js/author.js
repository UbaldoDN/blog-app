document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();
  
    if (currentPage === 'posts.html') {
      // Lógica para manejar la página de posts
    } else if (currentPage === 'author.html') {
      fetchAuthors();
    } else if (currentPage === 'admin.html') {
      // Lógica para manejar la página de administradores
    }
  });
  
  async function fetchAuthors() {
    try {
      const response = await fetch('http://localhost/api/v1/posts');
      const posts = await response.json();
      displayPosts(posts.data);
    } catch (error) {
      console.error('Error fetching posts:', error);
    }
  }
  
  function displayPosts(posts) {
    const postsContainer = document.getElementById('posts');
    postsContainer.innerHTML = '';
  
    posts.forEach(post => {
      const postElement = document.createElement('div');
      postElement.className = 'bg-white p-4 rounded-lg shadow mb-4';
      postElement.innerHTML = `
        <h3 class="text-xl font-bold mb-2">${post.title}</h3>
        <p>${post.body}</p>
      `;
      postsContainer.appendChild(postElement);
    });
  }