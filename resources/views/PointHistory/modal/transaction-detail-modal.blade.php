<style>
  /* The Modal (background) */
  .modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 1;
    /* Sit on top */
    padding-top: 20px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.4);
    /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%;
    border-radius: 5px;
    height: 85%;
    overflow: auto;
  }

  .modal-header {
    display: flex;
    justify-content: space-between
  }

  .modal-header p {
    font-size: 26px;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    font-size: 26px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  #transactions_table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px
  }

  #transactions_table td,
  #transactions_table th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #transactions_table tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #transactions_table tr:hover {
    background-color: #ddd;
  }
  #line-items {
    border-collapse: collapse;
    width: 100%;
    overflow-x: auto;
    margin-top: 10px
  }
  .line-item-container{
    width: 100%;
    overflow-x: auto;
  }

  #line-items td{
    border: 1px solid #ddd;
    font-size: 13px;
    padding: 8px;
  }
  #line-items th{
    font-size: 14px;
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  #line-items tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #line-items tr:hover {
    background-color: #ddd;
  }

  @media only screen and (min-width: 350px) and (max-width: 767px) {
    .modal-content {
      width: 90%;
      height: 85%;
      overflow: auto;
    }
  }
</style>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <p>Transaction Detail</p>
      <span class="close">&times;</span>
    </div>

    <div class="modal-body">
      <table id="transactions_table">
        <tr>
          <td colspan="2" align="center">No data found</td>
        </tr>
      </table>
      
      <p class="text-xl mt-4">Line Items</p>
      <div class="line-item-container">
        <table id="line-items">
          <thead>
            <tr>
              <th>Serial</th>
              <th>Item Code</th>
              <th>Amount</th>
              <th>Description</th>
              <th>Discount</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th>Value</th>
            </tr>
          </thead>
          <tbody id="line-items-list">
            <tr>
              <td colspan="8" align="center">No data found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div style="border-bottom: 1px solid #dddddd;margin-top: 40px;">

    </div>
  </div>

</div>


<script>
  // Get the modal
    var modal = document.getElementById("myModal");
    
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    
    // When the user clicks the button, open the modal 
    function openTransactionModal(trans)
    {
      var transaction =  `
      <tr>
          <td>Serial Number</td>
          <td>${trans.number}</td>
      </tr>
      <tr>
          <td>Amount</td>
          <td>${trans.amount}</td>
      </tr>
      <tr>
          <td>Discount</td>
          <td>${trans.discount}</td>
      </tr>
      <tr>
          <td>Gross Amount</td>
          <td>${trans.gross_amount}</td>
      </tr>
      <tr>
          <td>Type</td>
          <td>${trans.type}</td>
      </tr>
      <tr>
          <td>Return Type</td>
          <td>${trans.return_type}</td>
      </tr>
      <tr>
          <td>Return Points On Bill</td>
          <td>${trans.returned_points_on_bill}</td>
      </tr>
      <tr>
          <td>Store</td>
          <td>${trans.store}</td>
      </tr>
      <tr>
          <td>Store Code</td>
          <td>${trans.store_code}</td>
      </tr>
      <tr>
          <td>Notes</td>
          <td>${trans.notes}</td>
      </tr>
      <tr>
          <td>Status</td>
          <td>${trans.delivery_status}</td>
      </tr>
      <tr>
          <td>Earned</td>
          <td>${trans.points.issued}</td>
      </tr>
      <tr>
          <td>Redeemed</td>
          <td>${trans.points.redeemed}</td>
      </tr>
      <tr>
          <td>Returned</td>
          <td>${trans.points.returned}</td>
      </tr>
        `;
      document.getElementById('transactions_table').innerHTML = transaction;

      const lineItemList = trans.line_items['line_item'];
      var lineItemRow = '';
      var lineItems = lineItemList.forEach((element,index) => {
          lineItemRow += `
         <tr>
            <td>${index + 1}</td>
            <td>${element.item_code}</td>
            <td>${element.amount}</td>
            <td>${element.description}</td>
            <td>${element.discount}</td>
            <td>${element.qty}</td>
            <td>${element.rate}</td>
            <td>${element.value}</td>
          </tr>
          `;
      });
      document.getElementById('line-items-list').innerHTML = lineItemRow;
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
</script>