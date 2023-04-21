<?php  include_once __DIR__ . '/header.php';
require_once __DIR__ . '/boot.php';
$user = null;

if (check_auth()) {
    $stmt = pdo()->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<?php if ($user) { ?>
    <form class="mt-5" method="post" action="do_logout.php">
        <button type="submit" class="btn btn-primary">Logout</button>
    </form>

    <form id="currience" method="POST" action="sum_currience.php">
        <label class="currency_label">
            <span class="currency">USD</span>
            <input type="number" name="sum" id="sum">
        </label>
        <label class="rub_label">
            <span>RUB</span>
            <input type="number" name="sum1" id="sum1" readonly>
        </label>
        <label for="reserve" class="btn btn-primary">Наоборот</label>
        <select name="currency" id="currency">
            <option value="usd">USD</option>
            <option value="eur">EUR</option>
            <option value="cny">CNY</option>
        </select>
        <input type="checkbox" name="reserve" id="reserve" style="display: none;">
        <button type="submit">Рассчитать</button>
    </form>

<?php } else { ?>

    <h1 class="mb-5">Регистрация</h1>
<?php flash(); ?>
<form action="register.php" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Логин</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" id="password" class="form-control" name="password" required>
    </div>
    <button class="btn btn-primary" type="submit">Зарегистрироваться</button>
</form>

    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

    <script>
            $sum = document.getElementById('sum')
            $currency = document.getElementById('currency')
            $reserve = document.getElementById('reserve')
            $sum1 = document.getElementById('sum1')

            $currency.addEventListener('change', (e) => {
                $span = document.querySelector('.currency')
                $span.textContent = e.target.value.toUpperCase()

                console.log(e.target.value)
            })

            reserve.addEventListener('change', (e) => {
                $currency_label = document.querySelector('.currency_label')
                $rub = document.querySelector('.rub_label')

                if (e.target.checked) {
                    $currency_label.querySelector('span').classList.remove('currency')
                    $currency_label.querySelector('span').textContent = 'RUB'
                    $rub.querySelector('span').classList.add('currency')
                    $rub.querySelector('span').textContent = $currency.value.toUpperCase()
                } else {
                    $rub.querySelector('span').classList.remove('currency')
                    $rub.querySelector('span').textContent = 'RUB'
                    $currency_label.querySelector('span').classList.add('currency')
                    $currency_label.querySelector('span').textContent = $currency.value.toUpperCase()
                }
            })

            currience.querySelector('button').addEventListener('click', (e) => {
                e.preventDefault()
                const body = {
                    sum: $sum.value,
                    currency: $currency.value,
                    reserve: $reserve.checked,
                    sum1: $sum1.value
                }
                console.log(body)
                $.ajax({
                    url: 'sum_currience.php',
                    method: 'post',
                    data: body,
                    dataType: 'json',
                    success: function(data){
                        console.log(data.data.sum)
                        $sum1.value = data.data.sum
                    },
                    error: function (data) {
                        console.log(data['responseText'])
                    }
                });
            })

    </script>
<?php include_once __DIR__ . '/footer.php';?>