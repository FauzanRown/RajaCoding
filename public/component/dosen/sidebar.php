<?php

$userData = getUser($_SESSION["id"])[0];
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div id="sidebar">
  <img class="logo" src="../../assets/img/Logo Putih.png" alt="" />
  <div class="profile">
    <img class="rounded-circle" src="<?= $userData['image'] == "user.png" ? "../../assets/img/user.png" : "../images/" . $userData['image'] ?>" alt="" />
    <h1><?= $userData["name"] ?></h1>
    <p><?= $userData["role"] ?></p>
  </div>

  <div class="actionButton">
    <a href="journalAnda.php" class="btn-link btn-active <?= $currentPage === 'journalAnda.php' ? 'active' : '' ?>">
      <svg
        width="25"
        height="25"
        viewBox="0 0 25 25"
        fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M6.24984 22.9167C5.67692 22.9167 5.18664 22.7129 4.779 22.3053C4.37136 21.8976 4.1672 21.407 4.1665 20.8334V4.16671C4.1665 3.59379 4.37067 3.10351 4.779 2.69587C5.18734 2.28824 5.67761 2.08407 6.24984 2.08337H18.7498C19.3228 2.08337 19.8134 2.28754 20.2217 2.69587C20.63 3.10421 20.8339 3.59449 20.8332 4.16671V20.8334C20.8332 21.4063 20.6294 21.8969 20.2217 22.3053C19.8141 22.7136 19.3234 22.9174 18.7498 22.9167H6.24984ZM11.4582 4.16671V10.5469C11.4582 10.7552 11.5408 10.9073 11.7061 11.0032C11.8714 11.099 12.0491 11.0945 12.2394 10.9896L13.5155 10.2344C13.6891 10.1302 13.8672 10.0782 14.0498 10.0782C14.2325 10.0782 14.4103 10.1302 14.5832 10.2344L15.8592 10.9896C16.0502 11.0938 16.2325 11.0983 16.4061 11.0032C16.5797 10.908 16.6665 10.7559 16.6665 10.5469V4.16671H11.4582Z"
          fill="white" />
      </svg>
      <p>Daftar Journal</p>
    </a>

    <a href="listMhs.php" class="btn-link btn-active <?= $currentPage === 'listMhs.php' ? 'active' : '' ?>">
      <svg
        width="25"
        height="25"
        viewBox="0 0 25 25"
        fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M12.5 0C5.5957 0 0 5.5957 0 12.5C0 19.4043 5.5957 25 12.5 25C19.4043 25 25 19.4043 25 12.5C25 5.5957 19.4043 0 12.5 0ZM19.79 13.54C19.79 14.1162 19.3262 14.5801 18.75 14.5801H14.585V18.75C14.585 19.3262 14.1211 19.79 13.5449 19.79H11.46C10.8838 19.79 10.4199 19.3213 10.4199 18.75V14.585H6.25C5.67383 14.585 5.20996 14.1162 5.20996 13.5449V11.46C5.20996 10.8838 5.67383 10.4199 6.25 10.4199H10.415V6.25C10.415 5.67383 10.8789 5.20996 11.4551 5.20996H13.54C14.1162 5.20996 14.5801 5.67871 14.5801 6.25V10.415H18.75C19.3262 10.415 19.79 10.8838 19.79 11.4551V13.54Z"
          fill="white" />
      </svg>

      <p>Mahasiswa Bimbingan</p>
    </a>
    <a href="kategori.php" class="btn-link btn-active <?= $currentPage === 'kategori.php' ? 'active' : '' ?>">
      <svg
        width="25"
        height="25"
        viewBox="0 0 25 25"
        fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M12.5 0C5.5957 0 0 5.5957 0 12.5C0 19.4043 5.5957 25 12.5 25C19.4043 25 25 19.4043 25 12.5C25 5.5957 19.4043 0 12.5 0ZM19.79 13.54C19.79 14.1162 19.3262 14.5801 18.75 14.5801H14.585V18.75C14.585 19.3262 14.1211 19.79 13.5449 19.79H11.46C10.8838 19.79 10.4199 19.3213 10.4199 18.75V14.585H6.25C5.67383 14.585 5.20996 14.1162 5.20996 13.5449V11.46C5.20996 10.8838 5.67383 10.4199 6.25 10.4199H10.415V6.25C10.415 5.67383 10.8789 5.20996 11.4551 5.20996H13.54C14.1162 5.20996 14.5801 5.67871 14.5801 6.25V10.415H18.75C19.3262 10.415 19.79 10.8838 19.79 11.4551V13.54Z"
          fill="white" />
      </svg>

      <p>Kategori Jurnal</p>
    </a>
    <a href="editProfile.php" class="btn-link btn-active <?= $currentPage === 'editProfile.php' ? 'active' : '' ?>">
      <svg
        width="25"
        height="25"
        viewBox="0 0 25 25"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink">
        <rect width="25" height="25" fill="url(#pattern0_368_1146)" />
        <defs>
          <pattern
            id="pattern0_368_1146"
            patternContentUnits="objectBoundingBox"
            width="1"
            height="1">
            <use
              xlink:href="#image0_368_1146"
              transform="scale(0.0111111)" />
          </pattern>
          <image
            id="image0_368_1146"
            width="90"
            height="90"
            preserveAspectRatio="none"
            xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFoAAABaCAYAAAA4qEECAAAACXBIWXMAAAsTAAALEwEAmpwYAAACPklEQVR4nO3dvYrUUByG8VjozayKYCVaiHbiBXgPdorYCDOdIihYiKWKH421na2l3oEgqxZ+NJZ+wCMHZ4uFuGYmyZvNnufpZ+fkt2cy/81smKYxMzMzMzOz/RtwAngCfAJ+Ah+BR8DRqdd2YAKuAr9p7xdweeo1zj5gSbduTL3WGpB3EjuALHYQWewgsthBZLGDyDs5+oWgy5y9tevJao/xsB9OfWy1YG9PfVy1YP+Y+phqwf4w9fHUgv24qRBuucFj+lSu+h1vaondYEnsK00t0Q51a82fcX0D5EVTS+y9G8fEFjmALXIAW+QAtsgBbJHXbJPRb63HzDqG/ZN5rZ1dTYxzxU3s0DVksUPIYgeR68Ymi1wnNtMgl5yTA4kcSORAIgcSOZDIgUQOJHIgkQOJHEjkQCIHEjmQyIFEDiRyIJFFHjA/GQkkciDgMHASOA9cKzfOJM4V1PRvWm0Bp0TO7fBy2647eeyAbyMpL0Zf/JwC3okcCHgzMPQyse7ZBbwaEHkx9fHs24AXIgcC7gwAvUysddYB50TuGXCsy24DzgK3gWfAS+A18HY1kew1/rmTV4A3hwABtoDvIrfjHALeD7X7gLvu5HaYM0O+1IFLni7aYR4MeVsCf6/4OSe3XCz6OuSbGHBkk1/QgQ642GFkq+uGmzECnneAFrtvwJeO0GL3afUlA/9rG7hXPtrq9WQ1V86//8Atb5D3gdNlzp56nbOvTAgr7LKzPwNPgQtlGpl6bWZmZmZmZtb06w8+ceqv9e1skAAAAABJRU5ErkJggg==" />
        </defs>
      </svg>

      <p>Edit Profile</p>
    </a>

    <a href="../logout.php" class="btn-link btn-active ">
      <svg
        width="25"
        height="25"
        viewBox="0 0 25 25"
        fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path
          d="M12.5002 2.60425C12.9146 2.60425 13.312 2.76887 13.605 3.06189C13.898 3.35492 14.0627 3.75235 14.0627 4.16675C14.0627 4.58115 13.898 4.97858 13.605 5.2716C13.312 5.56463 12.9146 5.72925 12.5002 5.72925H7.29183C7.1537 5.72925 7.02122 5.78412 6.92354 5.8818C6.82587 5.97947 6.771 6.11195 6.771 6.25008V18.7501C6.771 18.8882 6.82587 19.0207 6.92354 19.1184C7.02122 19.216 7.1537 19.2709 7.29183 19.2709H11.9793C12.3937 19.2709 12.7912 19.4355 13.0842 19.7286C13.3772 20.0216 13.5418 20.419 13.5418 20.8334C13.5418 21.2478 13.3772 21.6452 13.0842 21.9383C12.7912 22.2313 12.3937 22.3959 11.9793 22.3959H7.29183C6.32489 22.3959 5.39756 22.0118 4.71384 21.3281C4.03011 20.6443 3.646 19.717 3.646 18.7501V6.25008C3.646 5.28315 4.03011 4.35581 4.71384 3.67209C5.39756 2.98836 6.32489 2.60425 7.29183 2.60425H12.5002ZM18.8127 8.448L21.7595 11.3959C22.0521 11.6889 22.2165 12.086 22.2165 12.5001C22.2165 12.9141 22.0521 13.3113 21.7595 13.6042L18.8137 16.5522C18.5206 16.8453 18.123 17.01 17.7085 17.01C17.294 17.01 16.8964 16.8453 16.6033 16.5522C16.3102 16.259 16.1455 15.8615 16.1455 15.447C16.1455 15.0324 16.3102 14.6349 16.6033 14.3417L16.8825 14.0626H12.5002C12.0858 14.0626 11.6883 13.898 11.3953 13.6049C11.1023 13.3119 10.9377 12.9145 10.9377 12.5001C10.9377 12.0857 11.1023 11.6883 11.3953 11.3952C11.6883 11.1022 12.0858 10.9376 12.5002 10.9376H16.8825L16.6033 10.6584C16.4582 10.5133 16.3432 10.341 16.2647 10.1514C16.1862 9.96177 16.1458 9.75857 16.1459 9.55336C16.1459 9.34815 16.1864 9.14496 16.265 8.95539C16.3435 8.76582 16.4587 8.59359 16.6038 8.44852C16.7489 8.30345 16.9212 8.18839 17.1108 8.1099C17.3004 8.03142 17.5037 7.99105 17.7089 7.99109C17.9141 7.99114 18.1173 8.03161 18.3068 8.11018C18.4964 8.18876 18.6686 8.3039 18.8137 8.44904L18.8127 8.448Z"
          fill="white" />
      </svg>
      <p>Keluar</p>
    </a>
  </div>
</div>