<?php

    function send_multi_attach_mail($to, $subject, $message, $senderName, $senderEmail, $files = array()) {
            
        // Boundary  
        $semi_rand = md5(time());  
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

        $headers = [
            "From: $senderName<$senderEmail>\n",
            "MIME-Version: 1.0\n",
            "Content-Type: multipart/mixed;\n", 
            " boundary=\"{$mime_boundary}\""
        ];

        $body = [
            "--{$mime_boundary}\n",
            "Content-Type: text/html; charset=\"UTF-8\"\n",
            "Content-Transfer-Encoding: 7bit\n\n",
            "$message\n\n"
        ];

        if (!empty($files)) {
            for ($i=0; $i < count($files); $i++) { 
                if(is_file($files[$i])) {
                    $file_name = basename($files[$i]); 
                    $file_size = filesize($files[$i]); 

                    $handle = @fopen($files[$i], "rb"); 
                    $content = @fread($handle, $file_size);
                    @fclose($handle);

                    $encoded_content = chunk_split(base64_encode($content)); 

                    array_push($body , ...[
                        "--{$mime_boundary}\n",
                        "Content-Type: application/octet-stream; name=\"$file_name\"\n",
                        "Content-Description: $file_name\n",
                        "Content-Disposition: attachment;\n",
                        " filename=\"$file_name\"; size=$file_size;\n",
                        "Content-Transfer-Encoding: base64\n\n",
                        "{$encoded_content}\n\n"
                    ]);
                } 
            }
        }

        array_push($body , "--{$mime_boundary}--");
        $returnpath = "-f" . $senderEmail;

        # Send email 
        $mail = @mail($to, $subject, implode("", $body), implode("", $headers), $returnpath);
        
        # Return true, if email sent, otherwise return false 
        if($mail) { 
            return true;
        }
        else { 
            return false; 
        } 
    }
    
    function send_mail($to, $subject, $message, $senderName, $senderEmail, $cc = "", $bcc = "") {
        
        $headers = [
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=iso-8859-1", 
            "From: $senderName <$senderEmail>",
            "Reply-To: $senderEmail",
            "Cc: $cc",
            "Bcc: $bcc",
            "X-Mailer: PHP/" . phpversion()
        ];
        
        # Send email 
        $mail = @mail($to, $subject, $message, implode("\r\n" , $headers));
        
        # Return true, if email sent, otherwise return false 
        if($mail) {
            return true;
        }
        else {
            return false;
        }
    }
?>