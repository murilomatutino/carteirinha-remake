/* Avaliação por estrelas */
const starBoxs = document.querySelectorAll(".avaliacao");

/* função auxíliar para não repetir código */
function f(i)
{
    starBoxs[i].addEventListener('click', function(e){
    const classStar = e.target.classList;
    const stars = starBoxs[i].children;
    let avaliado = false;

    // convertendo stars para lsita
    const stars_list = Array.from(stars);

    // verifica se o usuario já fez uma avaliação
    stars_list.forEach(function(star)
    {
        if (star.classList.contains("ativo"))
        {
            avaliado = true;
        }
    });

    if (classStar.contains("star-icon") && avaliado === false)
    {
        classStar.add("ativo");    
    }
})
}

f(0);f(1);f(2);f(3);f(4);
