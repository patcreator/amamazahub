import React from 'react';
import AppLayout from '../Components/AppLayout';
import VideoFeed from '../Components/VideoFeed';
import { Head, router } from '@inertiajs/react';
import { motion } from 'framer-motion';

export default function Welcome({ videos, feedType }) {
    const handleTabChange = (type) => {
        router.get('/', { type }, { preserveState: true });
    };

    return (
        <AppLayout>
            <Head title="Home" />

            {/* Floating For You / Following Tabs (Top) */}
            <div className="absolute top-4 left-0 right-0 z-20 flex justify-center space-x-8 text-lg font-bold drop-shadow-md">
                <button
                    onClick={() => handleTabChange('following')}
                    className={`relative pb-1 ${feedType === 'following' ? 'text-white' : 'text-white/60 hover:text-white/80'} transition`}
                >
                    Following
                    {feedType === 'following' && <motion.div layoutId="tab" className="absolute bottom-0 left-0 right-0 h-1 bg-white rounded-full" />}
                </button>
                <button
                    onClick={() => handleTabChange('foryou')}
                    className={`relative pb-1 ${feedType === 'foryou' || !feedType ? 'text-white' : 'text-white/60 hover:text-white/80'} transition`}
                >
                    For You
                    { (feedType === 'foryou' || !feedType) && <motion.div layoutId="tab" className="absolute bottom-0 left-0 right-0 h-1 bg-white rounded-full" />}
                </button>
            </div>

            {/* Vertical Snap Scroll Feed */}
            <div className="flex-1 overflow-y-auto video-container">
                <VideoFeed videos={videos.data} />
            </div>
        </AppLayout>
    );
}
