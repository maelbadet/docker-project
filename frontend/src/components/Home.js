import React, { useState, useEffect, useContext } from "react";
import { UserContext } from "../UserContext";
import { useNavigate } from "react-router-dom";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { Navigation, Pagination } from "swiper/modules";
import "./css/home.css";
import Loader from "./loader";

function Home() {
    const { user, setUser } = useContext(UserContext);
    const navigate = useNavigate();
    const [products, setProducts] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch("http://localhost:8000/api/product-home")
            .then((response) => response.json())
            .then((data) => {
                if (data.products) {
                    setProducts(data.products);
                }
                setLoading(false);
            })
            .catch((error) => {
                console.error("Erreur lors du fetch des produits :", error);
                setLoading(false);
            });
    }, []);

    if (loading) {
        return <Loader />;
    }

    return (
        <div className="home-container">
            {/* Section Présentation */}
            <div className="intro-section">
                <h1>Bienvenue chez l'Egregor</h1>
                <p>
                    La moutarde Fallot, dernière moutarderie artisanale de France, incarne
                    un savoir-faire unique et une tradition ancestrale. Découvrez nos produits
                    authentiques et laissez-vous séduire par des saveurs incomparables.
                </p>
            </div>

            {/* Section Slider */}
            <div className="products-section">
                <h3>Nos derniers Produits</h3>
                <Swiper
                    modules={[Navigation, Pagination]}
                    spaceBetween={30}
                    slidesPerView={3}
                    navigation
                    pagination={{ clickable: true }}
                    style={{ padding: "20px" }}
                >
                    {products.map((product) => (
                        <SwiperSlide key={product.id}>
                            <div
                                onClick={() => navigate(`/product/${product.id}`)}
                                className="product-card"
                            >
                                <img
                                    src={`http://localhost:3000/img/${product.id}.png`}
                                    alt={product.name}
                                    className="product-image"
                                />
                                <div className="product-details">
                                    <h4 className="product-title">{product.name}</h4>
                                    <div className="product-info">
                                        <span className="product-format">{product.format} cl</span>
                                        <span className="product-price">{product.price}€</span>
                                    </div>
                                </div>
                            </div>
                        </SwiperSlide>
                    ))}
                </Swiper>
            </div>

            {/* Nouvelle Section : Pourquoi Fallot ? */}
            <div className="why-us-section">
                <h3>Pourquoi choisir la moutarde Fallot ?</h3>
                <div className="points">
                    <div className="point">
                        <img src="/path/to/icon1.png" alt="Artisanat" />
                        <h4>Artisanat Authentique</h4>
                        <p>
                            Une fabrication traditionnelle respectant des méthodes transmises
                            de génération en génération.
                        </p>
                    </div>
                    <div className="point">
                        <img src="/path/to/icon2.png" alt="Ingrédients de qualité" />
                        <h4>Ingrédients de Qualité</h4>
                        <p>
                            Des graines de moutarde rigoureusement sélectionnées et des
                            ingrédients naturels.
                        </p>
                    </div>
                    <div className="point">
                        <img src="/path/to/icon3.png" alt="Savoir-faire unique" />
                        <h4>Savoir-Faire Unique</h4>
                        <p>
                            Une expertise qui garantit des produits savoureux et
                            incomparables.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Home;
