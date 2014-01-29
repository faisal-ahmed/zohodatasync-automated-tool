<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mohammad Faisal Ahmed <faisal.ahmed0001@gmail.com>
 * Date: 1/29/14
 * Time: 6:37 PM
 * To change this template use File | Settings | File Templates.
 */

function migationFailedData()
{
    ?>
    <div class="block" style="margin: 10px 20px 25px 0px; padding-bottom: 0px;">
        <div class="block_head">
            <div class="bheadl"></div>
            <div class="bheadr"></div>
            <h2 style="margin: 0;">Zoho Data Sync Automated Tools Settings</h2>
        </div>
        <div class="block_content">
            <form action="" method="post">
                <?php if ($success != '') { ?>
                    <div class="message success"><?php echo $success ?></div><?php } ?>
                <?php if ($error != '') { ?>
                    <div class="message errormsg"><?php echo $error ?></div><?php } ?>
                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                    <thead>
                    <tr>
                        <th width="10" class="checkboxAlignMiddle"><input type="checkbox" class="check_all"/></th>
                        <th>Page title</th>
                        <th>Status</th>
                        <th>Date created</th>
                        <th>Author</th>
                        <td>&nbsp;</td>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td class="checkboxAlignMiddle"><input type="checkbox"/></td>
                        <td><a href="#">Aorem ipsum dolor</a></td>
                        <td>Published</td>
                        <td>20.03.2010</td>
                        <td><a href="#">John Doe</a></td>
                        <td class="delete"><a href="#">Delete</a></td>
                    </tr>

                    <tr>
                        <td class="checkboxAlignMiddle"><input type="checkbox"/></td>
                        <td><a href="#">Zn ac libero nunc, vel congue neque</a></td>
                        <td>Published</td>
                        <td>18.03.2010</td>
                        <td><a href="#">John Doe</a></td>
                        <td class="delete"><a href="#">Delete</a></td>
                    </tr>
                    </tbody>

                </table>

                <div class="tableactions">
                    <select style="height: 30px;">
                        <option>Actions</option>
                        <option>Delete</option>
                        <option>Edit</option>
                    </select>

                    <input type="submit" class="submit long" value="Apply to selected"/>
                </div>

                <div class="pagination right" style="padding-top: 10px;">
                    <a href="#">&laquo;</a>
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">4</a>
                    <a href="#">5</a>
                    <a href="#">6</a>
                    <a href="#">&raquo;</a>
                </div>

            </form>
        </div>
        <div class="bendl"></div>
        <div class="bendr"></div>
        <div class="clear"></div>
    </div>
<?php
}