"use client"

import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import CartSidebar from "@/components/CartSidebar";
import SearchModal from "@/components/SearchModal";
import NotFound from "@/pages/NotFound";

export default function NotFoundPage() {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <main>
        <NotFound />
      </main>
      <Footer />
      <CartSidebar />
      <SearchModal />
    </div>
  );
} 