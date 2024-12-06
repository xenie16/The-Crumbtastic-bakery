</header>
<main>
   <h1>Customers</h1>
   <div class="user-grid">
      <?php foreach ($users as $user) { ?>
         <div class="user-card">
            <h2><?= $user->getLastName() . " " . $user->getFirstName() ?></h2>
            <p>(<?= $user->getEmail() ?>)</p>
            <form method="post">
               <label>Status
                  <select name="statusId">
                     <?php foreach ($statuses as $status) { ?>
                        <option value="<?= $status->getId() ?>" <?= $status->getId() == $user->getStatusId() ? 'selected' : '' ?>><?= $status->getStatus() ?></option>
                     <?php } ?>

                  </select>
               </label>
               <input type="hidden" name="userId" value="<?= $user->getId() ?>">
               <input type="submit" name="updateButton" value="Update">
            </form>
         </div>
      <?php } ?>
   </div>

</main>