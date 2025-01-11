import React, { useState, useEffect, useContext } from "react";
import { UserContext } from "../UserContext";
import { useNavigate } from "react-router-dom";
import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import { Navigation, Pagination } from "swiper/modules";
import './css/home.css';
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

    const handleLogout = () => {
        localStorage.removeItem("userId");
        setUser(null);
        navigate("/login");
    };

    if (loading) {
        return <Loader />;
    }

    return (
        <div>
            <h2>Bienvenue chez l'Egregor</h2>
            <p>La moutarde Fallot, la moutarde qu'il vous faut !</p>

            <h3>Nos Produits</h3>

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
    );
}

export default Home;
