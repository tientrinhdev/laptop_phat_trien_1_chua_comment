<?function showCart()
{
    if (isset($_SESSION['cart']) && is_array(($_SESSION['cart']))) {
        if (sizeof($_SESSION['cart']) > 0) {
            $tong = 0;
            for ($i = 0; $i < sizeof(($_SESSION['cart'])); $i++) {
                $total = $_SESSION['cart'][$i][3] * $_SESSION['cart'][$i][4];
                $tong += $total;
                echo '<tr>
                <td align="center">' . ($i + 1) . '</td>
                <td align="center">' . $_SESSION['cart'][$i][1] . '</td>
                <td align="center"><img width="100px" src="uploads/' . $_SESSION['cart'][$i][2] . '"></td>
                <td align="center">' . $_SESSION['cart'][$i][3] . '</td>
                <td align="center">
                <input min="1"  max="10" style="width: 40px;" type="number" name="quantity[]" value="'.$_SESSION['cart'][$i][4].'" data-index="'.($i).'">
                <button class="update-btn" data-index="'.($i).'">Cập nhật</button>
                </td>
                <td align="center">' . $total . '</td>
                <td align="center">
                <a href="cart.php?delid=' . $i . '">Xóa</a> 
                </td>

            </tr>';
            }
            echo '<tfoot>
        <th colspan="4">Tổng:</th>
        <th colspan="3">' . $tong . '</th>
    </tfoot>';
        } else {
            echo "<h2>Giỏ hàng rỗng</h2>";
        }
    }
}

function totalOrder()
{
    $tong =0;
    if (isset($_SESSION['cart']) && is_array(($_SESSION['cart']))) {
        if (sizeof($_SESSION['cart']) > 0) {
            for ($i = 0; $i < sizeof(($_SESSION['cart'])); $i++) {
                $total = $_SESSION['cart'][$i][3] * $_SESSION['cart'][$i][4];
                $tong += $total;
            }
        }
    }
    return $tong;
}

?>