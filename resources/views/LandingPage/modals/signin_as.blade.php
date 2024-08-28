<!-- @extends('LandingPage.layouts.login_layout') -->

<style>
  /* General Modal Styles */
  .modal-content {
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    background: white;
    display: flex;
    flex-direction: column;
    border-radius: 20px;
    border: 1px solid #e0e0e0;
    max-width: 500px; /* Adjusted size */
    margin: auto;
  }

  .modal.fade .modal-dialog {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    transform: translateY(-100px);
    opacity: 0;
  }

  .modal.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
    max-width: 500px; /* Adjusted size */
    border-radius: 20px;
  }

  .modal-header {
    background: linear-gradient(to right, #66bb6a, #43a047); /* Green gradient */
    color: #fff;
    border-bottom: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem; /* Adjusted padding */
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }

  .modal-title {
    font-size: 24px;
    font-weight: bold;
  }

  .btn-close {
    background-color: transparent;
    border: none;
    font-size: 10px; /* Adjusted font size */
    color: white;
    cursor: pointer;
    padding: 0;
    margin-left: 10px; /* Adjusted margin */
  }

  .modal-body {
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    background: #f8f9fa;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
  }

  .icon-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
  }

  .icon-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 20px; /* Increased margin for better spacing */
  }

  .icon-circle {
    width: 80px; /* Increased size for better visibility */
    height: 80px; /* Increased size for better visibility */
    color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px; /* Increased size for better visibility */
    margin-bottom: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .icon-circle.admin {
    background-color: #66bb6a; /* Light Green */
  }

  .icon-circle.hikers {
    background-color: #ffa726; /* Orange */
  }

  .icon-circle.tourist-guide {
    background-color: #42a5f5; /* Blue */
  }

  .icon-circle:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  }

  .icon-circle.admin:hover {
    background-color: #43a047; /* Hover Green */
  }

  .icon-circle.hikers:hover {
    background-color: #fb8c00; /* Hover Orange */
  }

  .icon-circle.tourist-guide:hover {
    background-color: #1e88e5; /* Hover Blue */
  }

  .icon-label {
    font-size: 18px; /* Adjusted font size */
    font-weight: bold;
    text-align: center;
  }

  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
</style>




<div class="modal fade" id="signin_role" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Account For</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="icon-container">
            <div class="icon-item">
              <a href="{{route('register')}}" class="icon-circle admin">
                <i class="fas fa-user-shield"></i>
              </a>
              <div class="icon-label">Admin</div>
            </div>
            <div class="icon-item">
              <a href="{{route('visitor_login')}}" class="icon-circle hikers">
                <i class="fas fa-hiking"></i>
              </a>
              <div class="icon-label">Hikers</div>
            </div>
            <div class="icon-item">
              <a href="{{route('guide_login')}}" class="icon-circle tourist-guide">
                <i class="fas fa-user-tie"></i>
              </a>
              <div class="icon-label">Guide</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
