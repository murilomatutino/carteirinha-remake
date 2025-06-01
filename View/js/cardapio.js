/* Avaliação por estrelas */
const starBoxs = document.querySelectorAll(".avaliacao");

/* função auxíliar para não repetir código */
function f(i)
{
    starBoxs[i].addEventListener('click', function(e){
    const classStar = e.target.classList;
    const stars = starBoxs[i].children;

    // convertendo stars para lsita
    const stars_list = Array.from(stars);

    if (!classStar.contains("ativo") && classStar.contains("star-icon"))
    {
        stars_list.forEach(function(star)
        {
            star.classList.remove("ativo");
        });

        classStar.add("ativo");    
    }
})
}

f(0);f(1);f(2);f(3);f(4);
