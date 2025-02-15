<?php

function validateInput($input, $field_name, $unique = false, $array = null)
{
    $value = $error = '';
    if (!empty($input)) {
        if ($field_name === "Email" || $field_name === "Customer Email") {
            $value = filter_var($input, FILTER_SANITIZE_EMAIL);
        } else {
            if ($field_name === "Phone Number" || $field_name === "Customer Contact Number") {
                if (strlen($input) > 15) {
                    $error = $field_name . " must not exceed 15 characters";
                } else {
                    $value = filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                }
            } else {
                $value = filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
    } else {
        $error = $field_name . " is required";
    }

    if (!empty($value)) {
        if ($unique) {
            $lower_case_field_name = strtolower($field_name);
            $obj_taken = false;
            foreach ($array as $obj) {
                if ($obj[$lower_case_field_name] === $value) {
                    $obj_taken = true;
                    $value = "";
                    break;
                }
            }
            if ($obj_taken) {
                $error = "$field_name is already taken, try diffrent one";
            }
        }
    }


    return ['value' => $value, 'error' => $error];
}

function validatePassword($password, $password_title)
{
    $value = $error = '';

    if (!empty($password)) {
        $pass_len = strlen($password);
        if ($pass_len >= 8) {
            $value  = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        } else {
            $error = "$password_title must be atleast 8 charachters";
        }
    } else {
        $error = "$password_title is required";
    }

    return ['value' => $value, 'error' => $error];
}


function comparePassword($password, $password_title, $password2, $password2_title)
{
    $value = $error = '';

    if (!empty($password)  && !empty($password)) {
        if ($password === $password2) {
            $value = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $error =  "$password_title and $password2_title did not match";
        }
    }

    return ['value' => $value, 'error' => $error];
}


function array_value_sum($x, $y)
{
    $w = 0;
    foreach ($x as $z) {
        $w += $z[$y];
    }
    return number_format($w, 2);
}

function obscureName($name)
{
    $length = strlen($name);

    if ($length <= 2) {
        return $name;
    } else {
        $first = $name[0];
        $second = $name[1];
        $second_to_last = $name[$length - 2];
        $last = $name[$length - 1];
        $middle = str_repeat('*', $length - 4);
        return $first . $second . $middle . $second_to_last .  $last;
    }
}


function obscureEmail($email)
{
    list($local, $domain) = explode('@', $email);
    $domain = '@' . $domain;

    $length = strlen($local);

    if ($local <= 4) {
        return $email;
    } else {
        $first = substr($local, 0, 2);
        $last = substr($local, $length - 2);
        $middle = str_repeat('*', $length - 4);
        return $first . $middle . $last . $domain;
    }
}
