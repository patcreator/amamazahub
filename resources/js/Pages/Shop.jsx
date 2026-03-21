import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { ShoppingBag, Search, ShoppingCart, Tag, Truck, Star, ChevronRight, Filter } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Shop() {
    const products = [
        { id: 1, name: 'Premium Creator Light', price: '$45.00', sales: '2.4k', image: 'https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 2, name: 'Amazama Studio Mic', price: '$120.00', sales: '842', image: 'https://images.pexels.com/photos/164829/pexels-photo-164829.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 3, name: 'Vlog Tripod Pro', price: '$29.99', sales: '5.1k', image: 'https://images.pexels.com/photos/339379/pexels-photo-339379.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 4, name: 'RGB Phone Case', price: '$15.00', sales: '10k+', image: 'https://images.pexels.com/photos/1474132/pexels-photo-1474132.jpeg?auto=compress&cs=tinysrgb&w=300' },
    ];

    const categories = ['All', 'Electronics', 'Fashion', 'Beauty', 'Home', 'Toys'];

    return (
        <AppLayout>
            <Head title="Shop - AmazamaHub" />

            <div className="max-w-6xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                {/* Shop Header */}
                <div className="flex items-center justify-between mb-8">
                    <div className="flex items-center space-x-3">
                        <ShoppingBag size={28} className="text-primary" />
                        <h1 className="text-2xl font-black italic tracking-tighter">AmazamaShop</h1>
                    </div>
                    <div className="flex items-center space-x-6">
                        <Link href="/shop/cart" className="relative group">
                            <ShoppingCart size={24} className="group-hover:text-primary transition" />
                            <span className="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </Link>
                        <Link href="/shop/orders" className="text-gray-400 hover:text-white transition">
                            <Truck size={24} />
                        </Link>
                    </div>
                </div>

                {/* Search & Promo */}
                <div className="bg-gradient-to-r from-primary/10 to-purple-500/10 p-8 rounded-[40px] border border-primary/10 mb-10 overflow-hidden relative">
                    <div className="relative z-10 max-w-lg">
                        <h2 className="text-3xl font-black italic mb-4 leading-tight">Flash Sale! Up to <span className="text-primary">70% OFF</span></h2>
                        <div className="relative group mb-6">
                            <Search className="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-primary transition" size={18} />
                            <input
                                type="text"
                                placeholder="Search products, brands, or shops..."
                                className="w-full bg-black/40 border border-gray-800 rounded-full py-4 px-12 text-sm font-semibold focus:outline-none focus:border-primary transition"
                            />
                        </div>
                        <div className="flex space-x-4">
                            <div className="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-primary"><Truck size={14} /><span>Free Shipping</span></div>
                            <div className="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-green-400"><Tag size={14} /><span>Best Prices</span></div>
                        </div>
                    </div>
                    <ShoppingBag size={120} className="absolute -bottom-10 -right-10 text-primary opacity-5 -rotate-12" />
                </div>

                {/* Categories */}
                <div className="flex space-x-4 mb-10 overflow-x-auto pb-2 noscrollbar">
                    {categories.map((cat, i) => (
                        <button key={i} className={`px-6 py-2 rounded-full text-sm font-black italic border transition ${i === 0 ? 'bg-white text-black border-white' : 'bg-transparent text-gray-400 border-gray-800 hover:border-gray-600'}`}>
                            {cat}
                        </button>
                    ))}
                </div>

                {/* Product Grid */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    {products.map((prod) => (
                        <motion.div
                            key={prod.id}
                            whileHover={{ y: -8 }}
                            className="bg-gray-900/30 border border-gray-800 rounded-3xl overflow-hidden group cursor-pointer"
                        >
                            <Link href="/shop/product/1">
                                <div className="aspect-square relative overflow-hidden">
                                    <img src={prod.image} className="w-full h-full object-cover group-hover:scale-110 transition duration-700" />
                                    <div className="absolute bottom-3 left-3 bg-black/60 backdrop-blur-md px-2 py-1 rounded-md text-[8px] font-black text-primary">BESTSELLER</div>
                                </div>
                                <div className="p-4 space-y-2">
                                    <p className="text-sm font-bold truncate group-hover:text-primary transition">{prod.name}</p>
                                    <div className="flex items-center justify-between">
                                        <span className="text-lg font-black italic">{prod.price}</span>
                                        <span className="text-[10px] text-gray-500 font-bold italic">{prod.sales} sold</span>
                                    </div>
                                    <div className="flex items-center space-x-1 text-yellow-400">
                                        {[1, 2, 3, 4, 5].map(s => <Star key={s} size={10} fill="currentColor" />)}
                                        <span className="text-[10px] text-gray-600 ml-1 font-black">(120)</span>
                                    </div>
                                </div>
                            </Link>
                        </motion.div>
                    ))}
                </div>
            </div>
        </AppLayout>
    );
}
