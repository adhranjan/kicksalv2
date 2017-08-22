<?php


use App\WeekDay;
use Intervention\Image\Facades\Image;

function bookable(){
    $return[0]='Cant Book';
    $return[1]='Can Book';
    return $return;
}

function gender(){
    $return[0]='F';
    $return[1]='M';
    return $return;
}

function bookingStatus(){
    $return[0]='Pending';
    $return[1]='Accepted';
    $return[2]='Rejected';
    $return[3]='Cancelled';
    return $return;
}

function bookingPaymentStatus(){
    $return[0]='Not Paid';
    $return[1]='Partial Paid';
    $return[2]='Paid';
    return $return;
}


function getTransactionDetailHtml($nonPaidBooking){
    $remaining=$nonPaidBooking->getBookingAmount();

    $html='<table class="table">';
    $paid_here=0;
    if($nonPaidBooking->bookingPayments()->count()!=0){
        foreach($nonPaidBooking->bookingPayments as $index=>$payment){
            $html.="<tr class='text-primary'> <th colspan='2'><strong>".$payment->created_at->format('d M Y l')."</strong></th></tr>";
            if($payment->advance_booking!=0){
                $html.='<tr> <th>Advance</th> <td>';
                $html.=$payment->advance_booking;
                $html.='</td> </tr>';
                $remaining-=$payment->advance_booking;

            }
            if($payment->hand_cash_amount!=0){
                $html.='<tr> <th>Counter</th> <td>';
                $html.=$payment->hand_cash_amount;
                $html.='</td> </tr>';
                $remaining-=$payment->hand_cash_amount;
            }
            if($payment->discount!=0){
                $html.='<tr> <th>Discount</th> <td>';
                $html.=$payment->discount;
                $html.='</td> </tr>';
                $remaining-=$payment->discount;
            }

            $paid_here+=$payment->advance_booking;
            $paid_here+=$payment->hand_cash_amount;
        }
        $html.='<tr> <th>Total Paid</th> <td>';
        $html.=$paid_here;
        $html.='</td> </tr>';
    }else{
        $html.='<tr> <th class="text-danger">No Payment Made</th> <td>';
    }
    $html.='</table>';
    $data['html']=$html;
    $data['remaining']=$remaining;
    return $data;
}

function dayToWeekDay($date){
    return WeekDay::where('day',date('l', strtotime($date)))->first();
}


function getImageName($media){
    $imagename=md5($media.md5(date("Y-m-d h:i:sa")));
    $file = explode(".", $media);
    $extension= end ($file);
    $imagename=$imagename.".".$extension;
    return $imagename;
}

function imageAvatarUpload($image,$folder)
{
    $path = $image->store($folder);
    $image=Image::make('storage/app/'.$path);
    squareImage($image);
    return $path;
}

function squareImage($image){
    $height=$image->height();
    $width=$image->width();

    if($height>$width){
        $height=$width;
    }else{
        $width=$height;
    }
    $image->crop($width, $height);
    Image::make($image->save($image->dirname.'/'.$image->basename));
}

function deleteImage($image){
    if($image==null){
        return true;
    }
    unlink('assets/image/'.$image);
}

