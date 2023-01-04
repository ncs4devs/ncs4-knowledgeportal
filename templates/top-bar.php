<div class="kp-main-buttons-container">
  <div class="kp-main-button kp-search-button">
    <i class="dashicons dashicons-search kp-search-icon"></i>
    <input type="text" placeholder="Search the Knowledge Portal">
  </div>
  <div class="kp-main-button kp-contribute-button">
    <span>Contribute to the Knowledge Portal</span>
  </div>
</div>

<style>
  .kp-main-buttons-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .kp-main-button {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    border: 1px solid #000;
    padding: 0px 10px;
    margin: 10px;
    font-size: 18px;
    cursor: pointer;    
    font-size: 2rem;
  }

  .kp-search-button {
    background-color: blue;
    color: white;
  }

  .kp-search-icon {
    color: white;
  }

  .kp-contribute-button {
    color: #000;
  }

  .kp-main-button i {
    margin-right: 10px;
  }

  input {
  outline: none;
  background: transparent;  
  width: 100%;
  font-size: 2rem;
  color: white;
}
</style>
