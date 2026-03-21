import React from 'react';
import VideoCard from './VideoCard';

export default function VideoFeed({ videos }) {
    if (!videos || videos.length === 0) {
        return (
            <div className="h-full flex flex-col items-center justify-center text-gray-500">
                <p className="font-black italic text-xl">No videos found</p>
                <p className="text-xs uppercase tracking-widest mt-2">Try follow more creators</p>
            </div>
        );
    }

    return (
        <div className="w-full">
            {videos.map((video) => (
                <VideoCard key={video.id} video={video} />
            ))}
        </div>
    );
}
