
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 p-0 mt-1">   
        <?php
          $nama_bln = array(1 => "January", "February", "March", "April", "	May", "June", "July", "August", "September", "October", "November", "December");
        $now= $year.'-'.$month.'-'.'31';
        // $month=date('m');
        // $year=date('Y');
        $per_lokasi=array();
        $per_id=array();
        $qp=$this->db->select('id_perusahaan,lokasi')->where("id_brand='18' AND singkat NOT LIKE '%HO%'")->get('perusahaan');
        foreach(($qp->result()) as $dp){
            $per_id[$dp->id_perusahaan]=$dp->id_perusahaan;
            $per_lokasi[$dp->id_perusahaan]=$dp->lokasi;
        }
        $count_id=count($per_id)+1;
        ?>
        <div class="table-responsive">      
        <table class="table table-bordered table-hover nowrap" id="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="" colspan='<?= $count_id+1;?>'><b><?= $year.' '.$nama_bln[(int)$month] ?></b></th>
                    </tr>
                    <tr>
                        <th scope="col" class=""><b>KCA</b></th>
                        <?php
                        foreach($per_id as $id=> $val_id){
                            echo '<th scope="col" class="">'.$per_lokasi[$id].'</th>';
                        }
                        ?>
                         <th scope="col" class=""><b>Total</b></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Kas Unit</td>
                        <?php
                        $tot_kas_unit=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110103' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110103'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_kas_unit+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700;text-align:right;"><?= separator_harga($tot_kas_unit)?></td>
                    </tr>
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Kas AS</td>
                        <?php
                        $tot_as=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110102' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110102'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_as+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_as)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Bank Collection Unit</td>
                        <?php
                        $tot_bcu=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110202' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110202'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_bcu+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_bcu)?></td>
                    </tr>
                        
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Bank Collection AS</td>
                        <?php
                        $tot_bcas=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110201' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110201'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_bcas+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_bcas)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Bank Operation</td>
                        <?php
                        $tot_op=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110203' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110203'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_op+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_op)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Piutang Unit</td>
                        <?php
                        $tot_aru=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110401' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110401'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_aru+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_aru)?></td>
                    </tr>
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Piutang AS</td>
                        <?php
                        $tot_aras=0;
                        foreach($per_id as $id=> $val_id){
                            $saldo=0;
                            $saldo_awal= $this->db_mercedes->select('saldo_awal')->where("kode_akun='110403' AND id_perusahaan='$id'")->get('akun_saldo')->row()->saldo_awal;

                            $saldo=$saldo_awal;

                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE tgl <= '$now' AND id_perusahaan='$id'
                            AND kode_akun='110403'");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $saldo+=$da->total;
                                }else{
                                    $saldo-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($saldo).'</td>';
                            $tot_aras+=$saldo;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_aras)?></td>
                    </tr>
                        
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Unit Sales</td>
                        <?php
                        $tot_us=0;
                        foreach($per_id as $id=> $val_id){
                            $unit=$this->db_mercedes->select("COUNT(no_transaksi) as total")->where("id_perusahaan='$id' AND batal='n' AND  EXTRACT( YEAR_MONTH FROM tgl )='$year$month'")->get('penjualan_unit')->row()->total;
                            echo '<td class="" style=" text-align:right;">'.$unit.'</td>';
                            $tot_us+=$unit;
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_us)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Revenue Unit</td>
                        <?php
                        $tot_ru=0;
                        foreach($per_id as $id=> $val_id){
                            $revenue_unit[$id]=0;
                            $unit=0;$diskon=0;
                            $qsa_unit = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('410100','430100')");
                            foreach($qsa_unit->result() as $da){
                                if($da->dk=='D'){
                                    $unit+=$da->total;
                                }else{
                                    $unit-=$da->total;
                                }
                            }

                            $qsa_diskon = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('450100')");
                            foreach($qsa_diskon->result() as $da){
                                if($da->dk=='D'){
                                    $diskon+=$da->total;
                                }else{
                                    $diskon-=$da->total;
                                }
                            }

                            $revenue_unit[$id]=$unit-$diskon;

                            echo '<td class="" style=" text-align:right;">'.separator_harga(abs($revenue_unit[$id])).'</td>';
                            $tot_ru+=$revenue_unit[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_ru)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Revenue Workshop</td>
                        <?php
                        $tot_rws=0;
                        foreach($per_id as $id=> $val_id){
                            $revenue_workshop[$id]=0;
                            $workshop=0;$diskon=0;
                           
                            $qsa_workshop = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('420101','420201')");
                            foreach($qsa_workshop->result() as $da){
                                if($da->dk=='D'){
                                    $workshop+=$da->total;
                                }else{
                                    $workshop-=$da->total;
                                }
                            }

                            $qsa_diskon = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('450501')");
                            foreach($qsa_diskon->result() as $da){
                                if($da->dk=='D'){
                                    $diskon+=$da->total;
                                }else{
                                    $diskon-=$da->total;
                                }
                            }

                            $revenue_workshop[$id]=$workshop-$diskon;

                            echo '<td class="" style=" text-align:right;">'.separator_harga(abs($revenue_workshop[$id])).'</td>';
                            $tot_rws+=$revenue_workshop[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_rws)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Revenue Part Counter</td>
                        <?php
                        $tot_rpc=0;
                        foreach($per_id as $id=> $val_id){
                            $revenue_part_counter[$id]=0;
                           
                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('420202')");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $revenue_part_counter[$id]+=$da->total;
                                }else{
                                    $revenue_part_counter[$id]-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga(abs($revenue_part_counter[$id])).'</td>';
                            $tot_rpc+=$revenue_part_counter[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_rpc)?></td>
                    </tr>
                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Gross Profit Unit</td>
                        <?php
                        $tot_gpu=0;
                        foreach($per_id as $id=> $val_id){
                            $gp_unit[$id]=0;
                           
                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('501000')");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $gp_unit[$id]+=$da->total;
                                }else{
                                    $gp_unit[$id]-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($gp_unit[$id]).'</td>';
                            $tot_gpu+=$gp_unit[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_gpu)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Gross Profit Workshop</td>
                        <?php
                        $tot_gpws=0;
                        foreach($per_id as $id=> $val_id){
                            $gp_workshop[$id]=0;
                           
                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('505101','505201')");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $gp_workshop[$id]+=$da->total;
                                }else{
                                    $gp_workshop[$id]-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($gp_workshop[$id]).'</td>';
                            $tot_gpws+=$gp_workshop[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_gpws)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Gross Profit Part Counter</td>
                        <?php
                        $tot_gppc=0;
                        foreach($per_id as $id=> $val_id){
                            $gp_part_counter[$id]=0;
                           
                            $qsa = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('505202')");
                            foreach($qsa->result() as $da){
                                if($da->dk=='D'){
                                    $gp_part_counter[$id]+=$da->total;
                                }else{
                                    $gp_part_counter[$id]-=$da->total;
                                }
                            }

                            echo '<td class="" style=" text-align:right;">'.separator_harga($gp_part_counter[$id]).'</td>';
                            $tot_gppc+=$gp_part_counter[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_gppc)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Operating Expense</td>
                        <?php
                        $tot_opex=0;
                        foreach($per_id as $id=> $val_id){
                            $op_expences[$id]=0;
                            $opex_plus=0;
                            $opex_minus=0;
                            $q_opex_plus = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('601001', '601002', '601003','601004', '601006', '601007', '601008', '601009', '601010', '601012', '601015', '601016', '601017', '601018', '601019', '601020', '601090','603001' , '603002', '603003', '603005', '603006', '603007', '603008', '603090','613003','608010', '608009', '608007', '608015','608001', '608002', '608003', '608004', '608005', '608006', '608008', '608013', '608014','608016', '608011','604001', '604002', '604003','606001','606002', '606003','603004', '601005','609001', '609002', '609003', '609004', '609005', '609090','607001', '607002', '607003','611002','611001','605101', '605102', '605103', '605201', '605202', '605203','601014', '601091','601013', '602001', '602002', '612001','612002', '612003', '613001', '613004', '613005', '613006', '613007', '613090', '614001', '614002')");
                            foreach($q_opex_plus->result() as $da){
                                if($da->dk=='D'){
                                    $opex_plus+=$da->total;
                                }else{
                                    $opex_plus-=$da->total;
                                }
                            }

                            $q_opex_minus = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('601011')");
                            foreach($q_opex_minus->result() as $da){
                                if($da->dk=='D'){
                                    $opex_minus+=$da->total;
                                }else{
                                    $opex_minus-=$da->total;
                                }
                            }

                            $op_expences[$id] =(int)$opex_plus-(int)$opex_minus;



                            echo '<td class="" style=" text-align:right;">'.separator_harga($op_expences[$id]).'</td>';
                            $tot_opex+=$op_expences[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_opex)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Other Income</td>
                        <?php
                        $tot_inc=0;
                        foreach($per_id as $id=> $val_id){
                            $other_income[$id]=0;
                           
                            $q_o_inc = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('810001','910007','810090','810002', '810003', '810006', '810091')");
                            foreach($q_o_inc->result() as $da){
                                if($da->dk=='D'){
                                    $other_income[$id]+=$da->total;
                                }else{
                                    $other_income[$id]-=$da->total;
                                }
                            }
                            echo '<td class="" style=" text-align:right;">'.separator_harga($other_income[$id]).'</td>';
                            $tot_inc+=$other_income[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_inc)?></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Other Expenses</td>
                        <?php
                        $tot_exp=0;
                        foreach($per_id as $id=> $val_id){
                            $other_expenses[$id]=0;
                           
                            $q_o_exp = $this->db_mercedes->query("SELECT jumlah as total,dk FROM buku_besar WHERE EXTRACT( YEAR_MONTH FROM tgl )='$year$month' AND id_perusahaan='$id'
                            AND kode_akun IN ('613002','910001','910010','610001','910002', '910003', '910006', '910009', '910008', '910090')");
                            foreach($q_o_exp->result() as $da){
                                if($da->dk=='D'){
                                    $other_expenses[$id]+=$da->total;
                                }else{
                                    $other_expenses[$id]-=$da->total;
                                }
                            }
                            echo '<td class="" style=" text-align:right;">'.separator_harga($other_expenses[$id]).'</td>';
                            $tot_exp+=$other_expenses[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_exp)?></td>
                    </tr>


                    <tr>
                        <td scope="col" class="" style="font-weight: 700;" colspan="<?=$count_id+1?>"></td>
                    </tr>

                    <tr>
                        <td scope="col" class="" style="font-weight: 700;">Profit/Loss</td>
                        <?php
                        $tot_profit=0;
                        foreach($per_id as $id=> $val_id){
                            $op_profit[$id]=((abs($revenue_unit[$id])+abs($revenue_workshop[$id])+abs($revenue_part_counter[$id]))-($gp_part_counter[$id]+$gp_unit[$id]+$gp_workshop[$id]))-$op_expences[$id];
                            $profit[$id]=($op_profit[$id]+$other_income[$id])-$other_expenses[$id];
                            echo '<td class="" style=" text-align:right;">'.separator_harga($profit[$id]).'</td>';
                            $tot_profit+=$profit[$id];
                        }
                        ?>
                         <td class="" style="font-weight: 700; text-align:right;"><?= separator_harga($tot_profit)?></td>
                    </tr>



                    
                </tbody>
            </table>
        </div>      
    </div>
</div>

<script>
    $('document').ready(function(){   

      
    });
</script>

<script>
    $('#loading').hide();
</script>