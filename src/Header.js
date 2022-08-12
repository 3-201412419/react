/*eslint-disable*/
import react from 'react';


function Header(){
    return (
        <div className="plan_header">
            <img src={process.env.PUBLIC_URL + '/images/menu_white.png'}></img>
			<p>플랜 갤러리</p>
		</div>
    )
}

export default Header();