import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { ShoppingCart, Heart, Share2, Truck, ShieldCheck, Star, ChevronLeft, ChevronRight, MessageCircle } from 'lucide-react';
import { motion } from 'framer-motion';

export default function ProductDetail() {
    return (
        <AppLayout>
            <Head title="Product Detail - AmazamaShop" />

            <div className="max-w-6xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <Link href="/shop" className="inline-flex items-center space-x-2 text-gray-500 hover:text-white mb-8 transition">
                    <ChevronLeft size={20} />
                    <span className="text-sm font-black italic">Back to Shop</span>
                </Link>

                <div className="flex flex-col lg:flex-row gap-12">
                    {/* Left: Product Images */}
                    <div className="w-full lg:w-1/2 space-y-4">
                        <div className="aspect-square rounded-[40px] overflow-hidden bg-gray-900 border border-gray-800 relative group">
                            <img src="https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=800" className="w-full h-full object-cover group-hover:scale-105 transition duration-700" />
                            <div className="absolute top-6 right-6 flex flex-col space-y-3">
                                <button className="p-3 bg-black/40 backdrop-blur-md rounded-full hover:bg-black/60 transition"><Heart size={20} /></button>
                                <button className="p-3 bg-black/40 backdrop-blur-md rounded-full hover:bg-black/60 transition"><Share2 size={20} /></button>
                            </div>
                        </div>
                        <div className="flex space-x-4 overflow-x-auto pb-2 noscrollbar">
                            {[1, 2, 3, 4].map(i => (
                                <div key={i} className={`w-24 h-24 rounded-2xl overflow-hidden cursor-pointer border-2 ${i === 1 ? 'border-primary' : 'border-transparent'}`}>
                                    <img src={`https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=100&u=${i}`} className="w-full h-full object-cover" />
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Right: Product Info */}
                    <div className="w-full lg:w-1/2 space-y-8">
                        <div>
                            <p className="text-primary font-black italic uppercase tracking-widest text-[10px] mb-2">Creator Choice • Limited Edition</p>
                            <h1 className="text-4xl font-black italic tracking-tighter mb-4 leading-tight">Premium Creator Ring Light V2</h1>
                            <div className="flex items-center space-x-4">
                                <div className="flex items-center space-x-1 text-yellow-400">
                                    {[1, 2, 3, 4, 5].map(s => <Star key={s} size={14} fill="currentColor" />)}
                                </div>
                                <span className="text-sm text-gray-500 font-bold">4.9 (1,243 reviews) | 5.2k Sold</span>
                            </div>
                        </div>

                        <div className="text-3xl font-black italic tracking-tighter text-white">
                            $45.00 <span className="text-lg text-gray-500 line-through ml-3">$89.00</span>
                        </div>

                        <div className="space-y-4">
                            <p className="text-sm font-black italic uppercase tracking-widest text-gray-400">Color</p>
                            <div className="flex space-x-4">
                                {['Titanium Black', 'Frost White', 'Sunset Orange'].map((c, i) => (
                                    <button key={i} className={`px-4 py-2 rounded-xl text-xs font-bold border transition ${i === 0 ? 'bg-white text-black border-white' : 'bg-transparent text-gray-400 border-gray-800'}`}>{c}</button>
                                ))}
                            </div>
                        </div>

                        <div className="flex space-x-4 pt-4">
                            <button className="flex-1 bg-gray-900 border border-gray-800 text-white font-black italic py-4 rounded-2xl hover:bg-gray-800 transition transform active:scale-95 flex items-center justify-center space-x-2">
                                <ShoppingCart size={20} />
                                <span>Add to Cart</span>
                            </button>
                            <button className="flex-1 bg-primary text-black font-black italic py-4 rounded-2xl hover:scale-105 transition transform active:scale-95 flex items-center justify-center space-x-2 shadow-xl shadow-primary/20">
                                <span>Buy Now</span>
                            </button>
                        </div>

                        <div className="grid grid-cols-2 gap-4 pt-6">
                            <div className="flex items-center space-x-3 p-4 bg-gray-900/40 border border-gray-800 rounded-2xl">
                                <Truck size={24} className="text-primary" />
                                <div>
                                    <p className="text-[10px] font-black italic">Free Shipping</p>
                                    <p className="text-[8px] text-gray-500 font-bold">Estimated 3-5 days</p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-3 p-4 bg-gray-900/40 border border-gray-800 rounded-2xl">
                                <ShieldCheck size={24} className="text-green-400" />
                                <div>
                                    <p className="text-[10px] font-black italic">1 Year Warranty</p>
                                    <p className="text-[8px] text-gray-500 font-bold">Safe & Secure Payment</p>
                                </div>
                            </div>
                        </div>

                        <div className="pt-8 border-t border-gray-900">
                            <div className="flex items-center justify-between mb-4">
                                <p className="font-bold">About this item</p>
                                <ChevronRight size={18} className="text-gray-700" />
                            </div>
                            <p className="text-sm text-gray-400 leading-relaxed font-medium">The ultimate lighting solution for creators. Professional-grade LED beads, adjustable color temperature (3200K-5600K), and a heavy-duty tripod stand. Perfect for TikTok, YouTube, and live streaming.</p>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
