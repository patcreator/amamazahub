import React from 'react';
import AppLayout from '../Components/AppLayout';
import { Head, Link } from '@inertiajs/react';
import { ShieldCheck, Truck, CreditCard, ChevronLeft, Lock, Info } from 'lucide-react';
import { motion } from 'framer-motion';

export default function Checkout() {
    return (
        <AppLayout>
            <Head title="Checkout - AmazamaShop" />
            
            <div className="max-w-5xl mx-auto w-full py-8 px-4 pb-24 md:pb-8">
                <Link href="/shop/cart" className="inline-flex items-center space-x-2 text-gray-500 hover:text-white mb-10 transition">
                    <ChevronLeft size={20} />
                    <span className="text-sm font-black italic">Return to Cart</span>
                </Link>

                <div className="flex flex-col lg:flex-row gap-12">
                    {/* Left: Checkout Process */}
                    <div className="flex-1 space-y-8">
                        {/* Shipping Section */}
                        <div className="bg-gray-900/20 border border-primary/20 rounded-[40px] p-8 shadow-2xl relative overflow-hidden">
                            <div className="flex items-center justify-between mb-6">
                                <div className="flex items-center space-x-3">
                                    <div className="bg-primary/20 p-2 rounded-xl text-primary"><Truck size={20}/></div>
                                    <h2 className="text-xl font-black italic">Shipping Address</h2>
                                </div>
                                <Link href="/shop/addresses" className="text-[10px] font-black italic uppercase text-primary hover:underline">Change</Link>
                            </div>
                            <div className="px-1 space-y-1">
                                <p className="font-bold text-gray-200">John Doe</p>
                                <p className="text-xs text-gray-500 font-medium">123 Amazama St, Digital City, 90210</p>
                            </div>
                            <div className="absolute top-0 right-0 p-8 h-full flex flex-col justify-center translate-x-4 opacity-5 pointer-events-none">
                                <Truck size={100} />
                            </div>
                        </div>

                        {/* Payment Section */}
                        <div className="bg-gray-900/20 border border-gray-900 rounded-[40px] p-8">
                            <div className="flex items-center justify-between mb-6">
                                <div className="flex items-center space-x-3 text-gray-400">
                                    <div className="bg-gray-800 p-2 rounded-xl"><CreditCard size={20}/></div>
                                    <h2 className="text-xl font-black italic text-gray-200">Payment</h2>
                                </div>
                                <Link href="/shop/payments" className="text-[10px] font-black italic uppercase text-primary hover:underline">Edit</Link>
                            </div>
                            <div className="flex items-center justify-between p-5 bg-black/40 border border-gray-800 rounded-3xl">
                                <div className="flex items-center space-x-4">
                                     <div className="w-10 h-7 bg-blue-600 rounded flex items-center justify-center font-black italic text-[8px] text-white">VISA</div>
                                     <span className="text-sm font-bold text-gray-300">Visa •••• 4242</span>
                                </div>
                                <ShieldCheck size={18} className="text-green-400" />
                            </div>
                        </div>

                        {/* Items Preview */}
                        <div className="bg-gray-900/20 border border-gray-900 rounded-[40px] p-8">
                            <h2 className="text-sm font-black italic uppercase tracking-widest text-gray-400 mb-6">Review Items (2)</h2>
                            <div className="flex -space-x-4 overflow-hidden mb-4">
                                {[1,2].map(i => (
                                    <div key={i} className="w-16 h-16 rounded-2xl border-4 border-black/20 bg-gray-900 overflow-hidden relative group">
                                        <img src={`https://images.pexels.com/photos/190819/pexels-photo-190819.jpeg?auto=compress&cs=tinysrgb&w=100&u=${i}`} className="w-full h-full object-cover" />
                                    </div>
                                ))}
                            </div>
                            <p className="text-[10px] text-gray-500 font-bold italic">Standard Delivery arriving in 3-5 days</p>
                        </div>
                    </div>

                    {/* Right: Summary & Pay */}
                    <div className="w-full lg:w-96 space-y-6">
                        <div className="bg-gray-900/40 border border-gray-800 p-8 rounded-[40px] space-y-8 sticky top-24 shadow-2xl">
                             <h3 className="text-xl font-black italic tracking-tighter flex items-center space-x-2">
                                 <Lock size={18} className="text-primary" />
                                 <span>Final Summary</span>
                             </h3>
                             
                             <div className="space-y-4">
                                 <div className="flex justify-between">
                                     <span className="text-[10px] font-black italic uppercase text-gray-500">Subtotal</span>
                                     <span className="font-bold italic">$104.99</span>
                                 </div>
                                 <div className="flex justify-between">
                                     <span className="text-[10px] font-black italic uppercase text-gray-500">Shipping</span>
                                     <span className="text-green-400 font-bold italic">$0.00</span>
                                 </div>
                                 <div className="flex justify-between border-t border-gray-800 pt-4">
                                     <span className="text-sm font-black italic uppercase tracking-[0.2em]">Total</span>
                                     <span className="text-2xl font-black italic text-primary">$104.99</span>
                                 </div>
                             </div>

                             <button className="w-full bg-primary text-black font-black italic py-5 rounded-3xl hover:scale-105 transition transform active:scale-95 shadow-xl shadow-primary/20 text-lg uppercase tracking-widest">
                                 Complete Payment
                             </button>

                             <div className="flex items-start space-x-3 p-4 bg-primary/5 rounded-2xl border border-primary/10">
                                 <Info size={16} className="text-primary mt-0.5" />
                                 <p className="text-[9px] text-gray-400 leading-relaxed uppercase tracking-tighter">By completing your order, you agree to our Terms of Sale and Privacy Policy.</p>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
