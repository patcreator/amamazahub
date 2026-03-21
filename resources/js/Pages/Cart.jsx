import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { ShoppingCart, Trash2, Plus, Minus, ChevronRight, ShieldCheck, Truck } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Cart() {
    const cartItems = [
        { id: 1, name: 'Premium Creator Ring Light', price: 45.00, qty: 1, image: 'https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=300' },
        { id: 2, name: 'Vlog Tripod Pro', price: 29.99, qty: 2, image: 'https://images.pexels.com/photos/339379/pexels-photo-339379.jpeg?auto=compress&cs=tinysrgb&w=300' },
    ];

    return (
        <AppLayout>
            <Head title="Cart - AmazamaShop" />
            
            <div className="max-w-4xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <h1 className="text-2xl font-black italic tracking-tighter mb-10 px-2">Shopping Cart ({cartItems.length})</h1>

                <div className="flex flex-col lg:flex-row gap-8">
                    {/* Cart Items List */}
                    <div className="flex-1 space-y-4">
                        {cartItems.map((item) => (
                            <div key={item.id} className="bg-gray-900/30 border border-gray-800 p-6 rounded-[32px] flex items-center space-x-6 relative overflow-hidden group">
                                <div className="w-24 h-24 rounded-2xl overflow-hidden bg-black flex-shrink-0">
                                    <img src={item.image} className="w-full h-full object-cover" />
                                </div>
                                <div className="flex-1 min-w-0 py-1">
                                    <div className="flex justify-between items-start mb-2 pr-10">
                                        <h3 className="font-black italic text-sm truncate group-hover:text-primary transition">{item.name}</h3>
                                        <button className="text-gray-700 hover:text-red-500 transition absolute top-6 right-6"><Trash2 size={18} /></button>
                                    </div>
                                    <p className="text-xs text-gray-500 font-bold uppercase mb-4 tracking-widest">Creator Edition</p>
                                    
                                    <div className="flex items-center justify-between">
                                        <span className="text-lg font-black italic">${item.price.toFixed(2)}</span>
                                        <div className="flex items-center space-x-4 bg-black/40 border border-gray-800 rounded-xl px-2 py-1">
                                            <button className="p-1 hover:text-primary transition"><Minus size={14}/></button>
                                            <span className="text-xs font-black italic w-4 text-center">{item.qty}</span>
                                            <button className="p-1 hover:text-primary transition"><Plus size={14}/></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Order Summary */}
                    <div className="w-full lg:w-80 space-y-6">
                        <div className="bg-gray-900/40 border border-gray-800 p-8 rounded-[40px] space-y-6 shadow-2xl">
                            <h2 className="text-sm font-black italic uppercase tracking-widest text-gray-400">Order Summary</h2>
                            <div className="space-y-4 border-b border-gray-800 pb-6">
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Subtotal</span>
                                    <span className="font-black italic">$104.99</span>
                                </div>
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-500 font-bold uppercase tracking-wider text-[10px]">Shipping</span>
                                    <span className="text-green-400 font-black italic">Free</span>
                                </div>
                            </div>
                            <div className="flex justify-between items-center text-xl">
                                <span className="font-black italic text-sm tracking-widest uppercase">Total</span>
                                <span className="font-black italic text-primary">$104.99</span>
                            </div>
                            <button className="w-full bg-primary text-black font-black italic py-4 rounded-2xl hover:scale-105 transition transform active:scale-95 shadow-xl shadow-primary/20">
                                Checkout
                            </button>
                        </div>

                        <div className="flex flex-col space-y-3 px-4">
                             <div className="flex items-center space-x-3 text-[10px] text-gray-500 font-bold italic uppercase tracking-widest">
                                 <ShieldCheck size={14} className="text-green-400"/>
                                 <span>Secure Checkout</span>
                             </div>
                             <div className="flex items-center space-x-3 text-[10px] text-gray-500 font-bold italic uppercase tracking-widest">
                                 <Truck size={14} className="text-primary"/>
                                 <span>Standard Ground (Free)</span>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
